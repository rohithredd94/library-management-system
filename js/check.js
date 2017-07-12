$(document).ready(function() {
    // your js code goes here...
    var element = document.createElement("span");
    element.setAttribute("id", "spanfname");
    $(element).insertAfter("#fname");
    
    element = document.createElement("span");
    element.setAttribute("id", "spanlname");
    $(element).insertAfter("#lname");

    element = document.createElement("span");
    element.setAttribute("id", "spanaddress");
    $(element).insertAfter("#address");

    element = document.createElement("span");
    element.setAttribute("id", "spancity");
    $(element).insertAfter("#city");

    element = document.createElement("span");
    element.setAttribute("id", "spanstate");
    $(element).insertAfter("#state");

    element = document.createElement("span");
    element.setAttribute("id", "spanssn");
    $(element).insertAfter("#ssn");

    element = document.createElement("span");
    element.setAttribute("id", "spanphone");
    $(element).insertAfter("#phone");


    $("#fname").focusin(function(){
        $("#spanfname").empty().removeClass("ok").removeClass("error");
        var element = document.getElementById("spanfname")//.nextSibling;
        var node = document.createTextNode("only alphanumeric characters");
        element.appendChild(node);
        $(element).addClass("info");
    });
    $("#fname").focusout(function(){
        $("#spanfname").empty().removeClass("info").removeClass("ok").removeClass("error");
        var fname = $("#fname");
        if(fname.val().length != 0){
            var pattern = /^[a-zA-Z0-9 ]+$/;
            if(fname.val().match(pattern)){
                var element = document.getElementById("spanfname");
                var node = document.createTextNode("OK");
                element.appendChild(node);
                $(element).addClass("ok");
            }else{
                var element = document.getElementById("spanfname");
                var node = document.createTextNode("Error");
                element.appendChild(node);
                $(element).addClass("error");
            }
        }
    });

    $("#lname").focusin(function(){  
        $("#spanlname").empty().removeClass("ok").removeClass("error");
        var element = document.getElementById("spanlname");
        var node = document.createTextNode("only alphanumeric characters");
        element.appendChild(node);
        $(element).addClass("info");
    });
    $("#lname").focusout(function(){
        $("#spanlname").empty().removeClass("info").removeClass("ok").removeClass("error");
        var lname = $("#lname");
        if(lname.val().length != 0){ 
            var pattern = /^[a-zA-Z0-9 ]+$/;
            if(lname.val().match(pattern)){
                var element = document.getElementById("spanlname");
                var node = document.createTextNode("OK");
                element.appendChild(node);
                $(element).addClass("ok");
            }else{
                var element = document.getElementById("spanlname");
                var node = document.createTextNode("Error");
                element.appendChild(node);
                $(element).addClass("error");
            }
        }
    });

    $("#address").focusin(function(){  
        $("#spanaddress").empty().removeClass("ok").removeClass("error");
        var element = document.getElementById("spanaddress");
        var node = document.createTextNode("only alphanumeric characters");
        element.appendChild(node);
        $(element).addClass("info");
    });
    $("#address").focusout(function(){
        $("#spanaddress").empty().removeClass("info").removeClass("ok").removeClass("error");
        var address = $("#address");
        if(address.val().length != 0){ 
            var pattern = /^[a-zA-Z0-9 ]+$/;
            if(address.val().match(pattern)){
                var element = document.getElementById("spanaddress");
                var node = document.createTextNode("OK");
                element.appendChild(node);
                $(element).addClass("ok");
            }else{
                var element = document.getElementById("spanaddress");
                var node = document.createTextNode("Error");
                element.appendChild(node);
                $(element).addClass("error");
            }
        }
    });

    $("#city").focusin(function(){  
        $("#spancity").empty().removeClass("ok").removeClass("error");
        var element = document.getElementById("spancity");
        var node = document.createTextNode("only alphanumeric characters");
        element.appendChild(node);
        $(element).addClass("info");
    });
    $("#city").focusout(function(){
        $("#spancity").empty().removeClass("info").removeClass("ok").removeClass("error");
        var city = $("#city");
        if(city.val().length != 0){ 
            var pattern = /^[a-zA-Z0-9 ]+$/;
            if(city.val().match(pattern)){
                var element = document.getElementById("spancity");
                var node = document.createTextNode("OK");
                element.appendChild(node);
                $(element).addClass("ok");
            }else{
                var element = document.getElementById("spancity");
                var node = document.createTextNode("Error");
                element.appendChild(node);
                $(element).addClass("error");
            }
        }
    });

    $("#state").focusin(function(){  
        $("#spanstate").empty().removeClass("ok").removeClass("error");
        var element = document.getElementById("spanstate");
        var node = document.createTextNode("only alphanumeric characters");
        element.appendChild(node);
        $(element).addClass("info");
    });
    $("#state").focusout(function(){
        $("#spanstate").empty().removeClass("info").removeClass("ok").removeClass("error");
        var state = $("#state");
        if(state.val().length != 0){ 
            var pattern = /^[a-zA-Z0-9]+$/;
            if(state.val().match(pattern) && state.val().length == 2){
                var element = document.getElementById("spanstate");
                var node = document.createTextNode("OK");
                element.appendChild(node);
                $(element).addClass("ok");
            }else{
                var element = document.getElementById("spanstate");
                var node = document.createTextNode("Error");
                element.appendChild(node);
                $(element).addClass("error");
            }
        }
    });

    $("#ssn").focusin(function(){  
        $("#spanssn").empty().removeClass("ok").removeClass("error");
        var element = document.getElementById("spanssn");
        var node = document.createTextNode("Format: XXXXXXXXX: 9 digits");
        element.appendChild(node);
        $(element).addClass("info");
    });
    $("#ssn").focusout(function(){
        $("#spanssn").empty().removeClass("info").removeClass("ok").removeClass("error");
        var ssn = $("#ssn");
        if(ssn.val().length != 0){ 
            var pattern = /^[0-9]+$/;
            if(ssn.val().match(pattern)){
                var element = document.getElementById("spanssn");
                var node = document.createTextNode("OK");
                element.appendChild(node);
                $(element).addClass("ok");
            }else{
                var element = document.getElementById("spanssn");
                var node = document.createTextNode("Error");
                element.appendChild(node);
                $(element).addClass("error");
            }
        }
    });

    $("#phone").focusin(function(){  
        $("#spanphone").empty().removeClass("ok").removeClass("error");
        var element = document.getElementById("spanphone");
        var node = document.createTextNode("Format: XXXXXXXXX: 10 digits");
        element.appendChild(node);
        $(element).addClass("info");
    });
    $("#phone").focusout(function(){
        $("#spanphone").empty().removeClass("info").removeClass("ok").removeClass("error");
        var phone = $("#phone");
        if(phone.val().length != 0){ 
            var pattern = /^[0-9]+$/;
            if(phone.val().match(pattern)){
                var element = document.getElementById("spanphone");
                var node = document.createTextNode("OK");
                element.appendChild(node);
                $(element).addClass("ok");
            }else{
                var element = document.getElementById("spanphone");
                var node = document.createTextNode("Error");
                element.appendChild(node);
                $(element).addClass("error");
            }
        }
    });
});
