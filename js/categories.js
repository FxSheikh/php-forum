$(document).ready(
  function(){
    $("#categories").on("change",function(event){
      // console.log(event.target);
      if($(event.target).attr("checked")){
        $(event.target).removeAttr("checked");
      }
      else {
        $(event.target).attr("checked","1");
      }
      //get all inputs that have attribute "checked"
      var selected = $("#categories input[checked]");
      var values = new Array();
      for(i=0;i<selected.length;i++){
        values.push(selected[i].value);
      }
      // console.log(values);
      // send categories via ajax to getproducts.php
      var catdata = {categories:values};
      $.ajax({
        type:"POST",
        url:"ajax/getproducts.php",
        data:catdata,
        dataType:"json",
        encode: true
      })
      .done(function(data){
        // data contains a list of products
        // render the products on page
        renderProducts(data);
      });
    });  
  }
);