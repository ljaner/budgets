/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import '../scss/app.scss';
const $ = require('jquery');
window.jQuery = $;
window.$ = $;
require('bootstrap');

var currentTab = 0; // Current tab is set to be the first tab (0)

$(window).myCallback = function(data) {
    alert(JSON.stringify(data));
};


$(document).ready(function()
{

    showTab(currentTab); // Display the current tab

    $('#prevBtn').on('click', function(){
        nextPrev($(this),-1)
    });
    $('#nextBtn').on('click', function(e){
        e.preventDefault();
        nextPrev($(this), 1)
    });


    function loadCategories(){
        let category = $('.tab.active').find('[name="category"]');
        if(!category.length || $(category).find('option').length > 1) return;

        let api_url = 'https://api.habitissimo.es/category/list';

        $.ajax({
            url: api_url,
            type: 'GET',
            ContentType: 'application/json',
            dataType: 'json',
        }).done(function(response){ //
            //alert("done");
        }).fail( function(jqXHR, textStatus, errorThrown) {
            console.log(textStatus);
            console.log(jqXHR.responseText);

        });
    }

    function nextPrev(element, n) {
        // This function will figure out which tab to display
        let x = $(".tab");
        if (n == 1 && !validateForm()) return false;
        $(x[currentTab]).removeClass("active");
        currentTab = currentTab + n;
        $('.alert').remove();
        if (n === 1 && $(element).attr('type') === 'submit') {
            console.log("submit");
            submitForm();
        }
        showTab(currentTab);
    }

    function showTab(n) {
        // This function will display the specified tab of the form...
        var x = $(".tab");
        $(x[n]).addClass("active");
        //... and fix the Previous/Next buttons:
        if (n === 0) {
            $("#prevBtn").css('display','none');
        } else {
            $("#prevBtn").css('display','inline');
        }
        if (n >= ($(x).length - 1)) {
            $("#nextBtn").removeAttr("type").attr("type", "submit").text("Submit");
        } else {
            $("#nextBtn").removeAttr("type").attr("type", "button").text("Next");
        }
        if($(x[n]).find('[name="category"]')) loadCategories();
        if($(x[n]).find('[name="email"]')) checkEmailBudget();
        fixStepIndicator(n)
    }

    function validateForm() {
        var x, y, i, valid = true;
        y =  $(".tab.active").find("input , select , textarea");
        for (i = 0; i < y.length; i++) {
            if (y[i].hasAttribute('required') && y[i].value === "") {
                y[i].className += " invalid";
                valid = false;
            }
        }
        if (valid) {
            $($(".step")[currentTab]).addClass(" finish");
        }
        return valid; // return the valid status
    }

    function submitForm() {
        let form = $("#budget-request");
        let post_url = $(form).attr("action");
        let request_method = $(form).attr("method");
        let form_data =$(form).serialize();
        let message = "";
        $.ajax({
            url : post_url,
            type: request_method,
            data : form_data,
            dataType: 'json'
        }).done(function(response){ //

            message = "<div class=' mt-5 alert alert-success' role='success'> <h2 class='mb-4 text-success '>Hemos recibido tu presupuesto!</h2>"+
                "<h5 class='mb-4 '>En breves nos pondremos en contacto contigo</h5></div>";
            $('#budget-request').html(message);

        }).fail( function(jqXHR, textStatus, errorThrown) {
            let response = $.parseJSON(jqXHR.responseText);
            if(jqXHR.status === 400 ){
                if(response.errors) {
                    message = '<div class="alert alert-danger" role="alert">';
                    let x = $(".tab");
                    currentTab = currentTab -1;
                    $(x[currentTab]).addClass("active");
                    $('.tab.active input').removeClass(" invalid");

                    $.each(response.errors, function(key, value){
                        message += key+': '+ value;
                        $("[name="+ key.toLowerCase()+"]").addClass(" invalid");
                    });
                    message += '</div>';
                    $('#budget-request .errors').prepend(message);

                }
            } else {
                message = '<div> <h4 class="alert alert-danger" role="alert">Ha habido un problema, porfavor intentalo mas tarde!</h4></div>';
                $('#budget-request').prepend(message);
            }
        });

    }

    function checkEmailBudget()
    {
        let email = $('.tab.active').find('[name="email"]');
        let url = "/check-email-budget";
        $(email).unbind().change(function(){
            $.ajax({
                url: url,
                type: 'GET',
                data: {'email': $(email).val()},
                ContentType: 'application/json',
                dataType: 'json',
            }).done(function(response){ //
                if(response.error) {
                    $(email).parent().append('<small id="email-check" class="p-1 form-text text-muted alert-danger"> '+response.error+'</small>');
                } else {
                    $('#email-check').remove();
                }
            }).fail( function(jqXHR, textStatus, errorThrown) {

            });
        });
    }

    function fixStepIndicator(n) {
        var i, x = $(".step");
        for (i = 0; i < x.length; i++) {
            x[i].className = x[i].className.replace(" active", "");
        }
        //... and adds the "active" class on the current step:
        $(x[n]).addClass(" active");
    }
});






