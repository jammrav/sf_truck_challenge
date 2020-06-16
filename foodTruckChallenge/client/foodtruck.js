$( "form" ).submit(function( e ) {
  e.preventDefault(); // avoid to execute the actual submit of the form.

    var form = $(this);
    if($("#lat").val() == '' || $("#lon").val() == '') {
        alert("Please enter valid latitude and longitude");
        return false;
    } else {
    $.ajax({
           type: "POST",
           url: "/foodTruckChallenge/server/api.php",
           data: form.serialize(), // serializes the form's elements.
           success: function(data1)
           {
               var items = [];
                data1 = $.parseJSON(data1);
                $(".container").html("");
                if(data1.error!="undefined" &&  data1.error !==undefined && data1.error !=="") {
                     items.push( "<div class='row'><div class='cell name'>An error occured.</div></div>" );
                } else {
                    $.each(data1, function(i, item) {
                            items.push( "<div class='row'><div class='cell name'>'" + item.name +"</div>" +
                                         "<div class='cell address'>"+item.address+ "</div>" + 
                                         "<div class='cell type'>"+item.facilityType+ "</div></div>" );
                    });
                    
                }
                $( "<div/>", {
                        "class": "container",
                        html: items.join( "" )
                      }).appendTo( "body" );
           }
         });
    }
});
