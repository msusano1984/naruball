var siteurl = "http://localhost/naruball/";

function postrequest(url, data, complete, fnerror){


	$.ajax({
      dataType: "json",
      url: siteurl+url,
      data: data,
      type: "POST", 
      success:complete,
      error:fnerror
       	
    });

}