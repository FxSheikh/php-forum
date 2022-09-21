$(document).ready(function(){

    $("#sel_category").change(function(){
        var catid = $(this).val();
        console.log(catid);

        $.ajax({
            url: 'ajax/getposts.php',
            type: 'POST',
            data: {category:catid},
            dataType: 'json',
            success:function(response){

            console.log(response);
                var len = response.length;
                // alert("sucess");

                $("#sel_post").empty();
                
                for( var i = 0; i<len; i++){
                    var id = response[i]['post_id'];
                    var content = response[i]['post_content'];
                    var truncLength = 80;
                    var truncatedContent = content.substring(0,truncLength);
                    truncatedContent += "......";
                    $("#sel_post").append("<option value='"+id+"'>"+truncatedContent+"</option>");

                }
            }
        });
    });

});