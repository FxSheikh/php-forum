$(document).ready(
  function(){
    loadCountry();
  }  
);

function loadCountry(){
        $.ajax({
            type: "POST",
            url: "ajax/countries.php",
            data: '',
            dataType: 'json',
            }).done(function( result ) {

                $("#country").empty();
                var len = result.length;
                
                // generating the countries select box
                for( var i = 0; i<len; i++){
                    // var id = result[i]['country_id'];
                    var country_name = result[i]['country_name'];
                    $("#country").append("<option value='"+country_name+"'>"+country_name+"</option>");
                }
                
                // setting the default value of the country select box to Australia
                var value = '#country option[value="'+initial_country+'"]';
                $(value).attr("selected",true);
                
                // setting the required attribute value of the country select box
                $("#country").attr("required", true);
            });
}