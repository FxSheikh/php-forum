$(document).ready(
  function(){
    loadProducts();
  }  
);

function loadProducts(){
  var catdata={categories:[0]};
  var url = "ajax/getproducts.php";
  $.ajax({type:'POST',
            url:url,
            data:'',
            dataType:'json',
            encode:true}
  )
  .done(function(data){
      renderProducts(data);
  //   var total = data.length;
  //   //get template
  //   var template = $("#product").html().trim();
  //   //get container
  //   var products = $("#products-container");
  //   //get row
  //   var row = $("#row").html().trim();
  //   //get data
  //   for(i=0;i<total;i++){
  //     var name = data[i].name;
  //     var image = 'images/'+data[i].image_file;
  //     var price = data[i].price;
  //     var desc = data[i].description;
  //     var id = 'viewdetails.php?id='+data[i].id;
      
  //     var clone = $(template);

  //     //fill the template
  //     $(clone).find('.product-title').text(name);
  //     $(clone).find('.product-image').attr('src',image);
  //     $(clone).find('.price').text(price);
  //     $(clone).find('.product-desc').html(desc);
  //     $(clone).find('.product-detail').attr('href',id);
      
  //     if(i % 4 == 0){
  //     var productrow = $(row);
  //       productrow.append(clone);
        
  //     }
  //     else{
  //       productrow.append(clone);
  //     }
  //     if(i % 4 == 3){
  //       products.append(productrow);
  //     }
  //     // append the template to the
 
  //   }
    
  });
}

function renderProducts(data){
    var total = data.length;
    console.log(data.length);
    //get template
    var template = $("#product").html().trim();
    //get container
    var products = $("#products-container");
    //empty the container
    products.empty();
    //get row
    var row = $("#row").html().trim();
    //get data
    for(i=0;i<total;i++){
      var name = data[i].name;
      var image = 'images/'+data[i].image_file;
      var price = data[i].price;
      var desc = data[i].description;
      var id = 'viewdetails.php?id='+data[i].id;
      
      var clone = $(template);

      //fill the template
      $(clone).find('.product-title').text(name);
      $(clone).find('.product-image').attr('src',image);
      $(clone).find('.price').text(price);
      $(clone).find('.product-desc').html(desc);
      $(clone).find('.product-detail').attr('href',id);
      
      if(i % 4 == 0){
      var productrow = $(row);
        productrow.append(clone);
        
      }
      else{
        productrow.append(clone);
      }
      if(i % 4 == 3 || i==total-1){
        products.append(productrow);
      }
      // append the template to the
 
    }  
}