function testForPHP() {
    var package_type;
    var weight;
    var dimension1;
    var dimension2;
    var dimension3;
    var courier_type;
    var delivery_time;
    var delivery_type;

    //Get package type
    if(document.getElementById('default_package').checked) {
        package_type = 'default_package';
    }
    if(document.getElementById('fragile_package').checked) {
        package_type = 'fragile_package';
    }
    if(document.getElementById('spoilable_package').checked) {
        package_type = 'spoilable_package';
    }

    //Get weight
    weight = document.getElementById('weight').value;

    //Get dimensions of package
    dimension1 = document.getElementById('dimension1').value;
    dimension2 = document.getElementById('dimension2').value;
    dimension3 = document.getElementById('dimension3').value;

    //Get courier type
    if(document.getElementById('default_courier').checked) {
        courier_type = 'default_courier';
    }
    else if(document.getElementById('fast_courier').checked) {
        courier_type = 'fast_courier';
    }
    else if(document.getElementById('heavy_courier').checked) {
        courier_type = 'heavy_courier';
    }

    //Get time
    if(document.getElementById('default_time').checked) {
        delivery_time = 'not specified';
    }
    else {
        delivery_time = document.getElementById('date_day').value + '-' + document.getElementById('date_month').value + '-' +
            document.getElementById('date_year').value;
    }

    //Get delivery type
    if(document.getElementById('deliver_person').checked) {
        delivery_type = 'deliver_person';
    }
    else if(document.getElementById('deliver_pickup_location').checked) {
        delivery_type = 'deliver_pickup_location';
    }
    else if(document.getElementById('deliver_address').checked) {
        delivery_type = 'deliver_address';
    }
    alert(package_type + '\n' + weight + '\n' + dimension1 + '\n' + dimension2 + '\n' + dimension3 + '\n' + courier_type + '\n'
        + delivery_time + '\n' + delivery_type
    );

    sessionStorage.setItem("package_type", package_type);
    sessionStorage.setItem("weight", weight);
    sessionStorage.setItem("dimension1", dimension1);
    sessionStorage.setItem("dimension2", dimension2);
    sessionStorage.setItem("dimension3", dimension3);
    sessionStorage.setItem("courier_type", courier_type);
    sessionStorage.setItem("delivery_time", delivery_time);
    sessionStorage.setItem("delivery_type", delivery_type);
    alert("done");

    /*
    var userdata = {'package_type':package_type,'weight':weight,'dimension1':dimension1,'dimension2':dimension2,'dimension3':dimension3,
        'courier_type':courier_type,'delivery_time':delivery_time, 'delivery_type': delivery_type};
    $.ajax({
        type: "POST",
        url: "jdbc:mysql://localhost:3306/projetdb",
        data: userdata,
        success: function(data){
            console.log(data);
        }
    });
    */
}