window.addEventListener('load',function(){
  if(document.getElementById('price-range')){
    var slider = document.getElementById('price-range');
    var display = document.getElementById('price-display');
    //set display value to slider's
    display.value = slider.value;
    //listen for slider changes
    slider.addEventListener('input',function(event){
        //get value of slider
        var val = event.target.value;
        display.value = val;
    });
  }
  if(document.getElementById('product-filter')){
    var filterform = document.getElementById('product-filter');
    filterform.addEventListener('reset', function(e){
        e.preventDefault();
        //count input elements
        var inputs = filterform.getElementsByTagName('input');
        for(i=0;i<inputs.length;i++){
          var formelement = inputs[i];
          if(formelement.type=='checkbox'){
            formelement.removeAttribute('checked');
          }
          if(formelement.type=='range'){
            //get maximum value
            var maxvalue = formelement.getAttribute('max');
            //set value back to maximum
            formelement.setAttribute('value',maxvalue);
            document.getElementById('price-display').value=maxvalue;
          }
        }
    });
  }
  //--show profile image when selected
  //if the profile image upload exits
  if(document.getElementById('profile-input')){
    var profileimg = document.getElementById('profile-input');
    profileimg.addEventListener('change',onProfileInput,false);
  }
  if(document.getElementById('password1')){
    var pw1 = document.getElementById('password1');
    var pw2 = document.getElementById('password2');
    var pwg = document.getElementById('password-group');
    var pwerror = document.getElementById('password-error');
    pw2.addEventListener('input',function(){
      var pwresult = passwordCheck(pw1.value,pw2.value);
      switch(pwresult){
        case 0:
          formStatus(pwg,0);
          pwerror.innerHTML = "passwords are not the same";
          break;
        case 1:
          formStatus(pwg,1);
          pwerror.innerHTML = "";
          break;
        case 2:
          formStatus(pwg,0);
          pwerror.innerHTML = "passwords are too short";
          break;
        case 3:
          formStatus(pwg,0);
          pwerror.innerHTML = "passwords are too short";
          break;
        default:
          break;
      }
    });
    pw1.addEventListener('change',function(){
      //empty the second field
      pw2.value = "";
    });
  }

  //check for state and country dropdowns
  if(document.getElementById('state') && document.getElementById('country')){
    var state = document.getElementById('state');
    var country = document.getElementById('country');
    var stateval = state.value;
    var countryval = country.value;
    //if either is emtpy or null then bind event listeners
    // if(!stateval || !countryval){
      //disable state
      state.setAttribute('disabled','disabled');
      // add listener to country for when user selects country
      country.addEventListener('change',selectState);
    // }
  }
});

function selectState(event){
  var selectedcountry = event.target.value;
  console.log(selectedcountry);
  if(selectedcountry){
    //empty the state list
    var state = document.getElementById('state');
    state.innerHTML = "";
    var option = document.createElement('OPTION');
    option.setAttribute('value','');
    state.appendChild(option);

    // var request = new XMLHttpRequest();
    // request.addEventListener('readystatechange',onReady);
    // request.open('GET','ajax/getstates.php',true);
    // var data = "{country:"+selectedcountry+"}";
    // request.send(data);
    var countrydata = {'country':selectedcountry};
    $.ajax({type:'GET',
             url:'ajax/getstates.php',
             data:countrydata,
             dataType:'json',
             encode:true}
    ).done(function(data){
      var len = data.length;
      var i=0;
      for(i=0;i<len;i++){
        var opt = '<option value="'+data[i].code+'">'+data[i].name+'</option>';
        // document.getElementById('state').appendChild(opt);
        $('#state').append(opt);
        document.getElementById('state').removeAttribute('disabled');
      }
    });
  }
}

function onReady(event){
  //when reponse is received
  console.log(event);
  
}

function formStatus(formgroup,status){
  switch(status){
    case 0:
      formgroup.classList.remove('has-success');
      formgroup.classList.add('has-error');
      break;
    case 1:
      formgroup.classList.remove('has-error');
      formgroup.classList.add('has-success');
      break;
    default:
      break;
  }
}

function passwordCheck(pass1,pass2){
  var status = 0;
  // if passwords are equal and at least 8 chars return 1
  // if passwords are equal and less than 8 return 2
  // if passwords are not equal return 0
  //if passwords are equal and they are both more than 8 characters
  if(pass1.length < 8 || pass2.length < 8){
    status = 3;
    return status;
  }
  else if(pass1 !== pass2){
    status = 0;
    return status;
  }
  else if((pass1==pass2) && (pass1.length == pass2.length) && pass1.length < 8){
    status = 2;
    return status;
  }
  else if(pass1==pass2 && pass1.length >= 8){
    status = 1;
    return status;
  }
  else{
    return status;
  }
}

function onProfileInput(event){
  document.getElementById('image-upload').classList.remove('has-error');
  document.getElementById('profile-error').innerHTML="";
  var files = event.target.files;
  var errors = [];
  //we only need one image so we use array member no 0
  var imagefile = files[0];
  var selected = document.getElementById('selected-image');

  var imagename = imagefile.name;
  //get the image size as kilobytes
  var imagesize = Math.ceil(imagefile.size/1024);
  //check the image size
  if(imagesize > 1024){
    var errorsize = {name: "size", message: "larger than 1MB"};
    errors.push(errorsize);
  }
  //display image size
  selected.innerHTML = imagename+" "+imagesize+"kb";
  //check for errors
  if(errors.length){
    document.getElementById('image-upload').classList.add('has-error');
    document.getElementById('profile-error').innerHTML=errors[0].message;
    document.getElementById('submit').classList.add('disabled');
  }
  else{

    var reader = new FileReader();
    reader.addEventListener('load',function(event){
      var profileimg = event.target.result;
      document.getElementById('profile-image').src = profileimg;
    });
    reader.readAsDataURL(imagefile);
    document.getElementById('submit').classList.remove('disabled');
  }

}