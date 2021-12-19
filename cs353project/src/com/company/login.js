function checkButton() {
    if(document.getElementById('customer').checked) {
        document.getElementById("test").innerHTML = `
            <input type="radio" id="customer"
            name="registertype" value="customer" onclick="checkButton()" checked required>
            <label for="customer">Customer</label>
        
            <input type="radio" id="courier"
            name="registertype" value="courier" onclick="checkButton()">
            <label for="courier">Courier</label>
        
            <input type="radio" id="employee"
            name="registertype" value="employee" onclick="checkButton()">
            <label for="employee">Employe</label>
            <br/>
            <input type="radio" id="companyrepresentative"
            name="registertype" value="companyrepresentative" onclick="checkButton()">
            <label for="companyrepresentative">Company Representative</label>  
                
            <form action="" method="post">
                <!--   user name Input-->
                <input class="form-input" id="txt-input" type="text" placeholder="Username" name = "username" required>
                <br>
                
                <!--   Address Input-->
                <input class="form-input" type="text" placeholder="Address" id="txt-input"  name="address" required>
                <br>
                
                <!--   Email Input-->
                <input class="form-input" type="text" placeholder="Email" id="txt-input" name="email" required>
                <br>
                
                <!--   Phone Input-->
                <input class="form-input" type="text" placeholder="Phone" id="txt-input"  name="phone" required>
                <br>
                
                <!--   Password Input-->
                <input class="form-input" type="password" placeholder="Password" id="pwd"  name="password" required>
                <br>
                
                <!--      button LogIn -->
                <button class="log-in" type = "submit" name = "register_customer"> Register </button>
            </form>
            `
    }
    else if(document.getElementById('courier').checked) {
        document.getElementById("test").innerHTML = `
            <input type="radio" id="customer"
            name="registertype" value="customer" onclick="checkButton()" required>
            <label for="customer">Customer</label>
        
            <input type="radio" id="courier"
            name="registertype" value="courier" onclick="checkButton()" checked>
            <label for="courier">Courier</label>
        
            <input type="radio" id="employee"
            name="registertype" value="employee" onclick="checkButton()">
            <label for="employee">Employe</label>
            <br/>
            <input type="radio" id="companyrepresentative"
            name="registertype" value="companyrepresentative" onclick="checkButton()">
            <label for="companyrepresentative">Company Representative</label>  
                
            <form action="" method="post">
                <!--   user name Input-->
                <input class="form-input" id="txt-input" type="text" placeholder="Username" name = "username" required>
                <br>
                
                <input class="form-input" id="txt-input" type="text" placeholder="E-mail" name = "email" required>
                <br>
                
                <input class="form-input" id="txt-input" type="text" placeholder="Phone" name = "phone" required>
                <br>
                
                <input class="form-input" id="txt-input" type="number" placeholder="Salary" name = "salary" required>
                <br>
                
                <input class="form-input" id="txt-input" type="number" placeholder="Price" name = "price" required>
                <br>
                <br>
                <p>Courier Type:</p>
                <input type="radio" id="heavy"
                name="couriertype" value="heavy" required>
                <label for="heavy">Heavy</label>
        
                <input type="radio" id="default"
                name="couriertype" value="default">
                <label for="default">Default</label>
        
                <input type="radio" id="fast"
                name="couriertype" value="fast">
                <label for="fast">Fast</label>
                
                <!--   Password Input-->
                <input class="form-input" type="password" placeholder="Password" id="pwd"  name="password" required>
    
                <!--      button LogIn -->
                <button class="log-in" type = "submit" name = "register_courier"> Register </button>
            </form>
            `
    }
    else if(document.getElementById('employee').checked) {
        document.getElementById("test").innerHTML = `
            <input type="radio" id="customer"
            name="registertype" value="customer" onclick="checkButton()" required>
            <label for="customer">Customer</label>
        
            <input type="radio" id="courier"
            name="registertype" value="courier" onclick="checkButton()">
            <label for="courier">Courier</label>
        
            <input type="radio" id="employee"
            name="registertype" value="employee" onclick="checkButton()" checked>
            <label for="employee">Employe</label>
            <br/>
            <input type="radio" id="companyrepresentative"
            name="registertype" value="companyrepresentative" onclick="checkButton()">
            <label for="companyrepresentative">Company Representative</label>  
                
            <form action="" method="post">
                <!--   user name Input-->
                <input class="form-input" id="txt-input" type="text" placeholder="Username" name = "username" required>
                <br>
                
                <!--   Salary Input-->
                <input class="form-input" type="number" placeholder="Salary" id="txt-input"  name="salary" required>
                <br>
                
                <!--   Email Input-->
                <input class="form-input" type="text" placeholder="Email" id="txt-input" name="email" required>
                <br>
                
                <!--   Phone Input-->
                <input class="form-input" type="text" placeholder="Phone" id="txt-input"  name="phone" required>
                <br>
                
                <!--   Password Input-->
                <input class="form-input" type="password" placeholder="Password" id="pwd"  name="password" required>
                <br>
                
                <!--      button LogIn -->
                <button class="log-in" type = "submit" name = "register_employee"> Register </button>
            </form>
            `
    }
    else if(document.getElementById('companyrepresentative').checked) {
        document.getElementById("test").innerHTML = `
            <input type="radio" id="customer"
            name="registertype" value="customer" onclick="checkButton()" required>
            <label for="customer">Customer</label>
        
            <input type="radio" id="courier"
            name="registertype" value="courier" onclick="checkButton()">
            <label for="courier">Courier</label>
        
            <input type="radio" id="employee"
            name="registertype" value="employee" onclick="checkButton()" >
            <label for="employee">Employe</label>
            <br/>
            <input type="radio" id="companyrepresentative"
            name="registertype" value="companyrepresentative" onclick="checkButton()" checked>
            <label for="companyrepresentative">Company Representative</label>  
                
            <form action="" method="post">
                <!--   Company Name Input-->
                <input class="form-input" type="text" placeholder="Company Name" id="txt-input"  name="companyname" required>
                <br>
            
                <!--   user name Input-->
                <input class="form-input" id="txt-input" type="text" placeholder="Username" name = "username" required>
                <br>
                
                <!--   Email Input-->
                <input class="form-input" type="text" placeholder="Email" id="txt-input" name="email" required>
                <br>
                
                <!--   Phone Input-->
                <input class="form-input" type="text" placeholder="Phone" id="txt-input"  name="phone" required>
                <br>
                
                <!--   Password Input-->
                <input class="form-input" type="password" placeholder="Password" id="pwd"  name="password" required>
                <br>
                
                <!--      button LogIn -->
                <button class="log-in" type = "submit" name = "register_companyrepresentative"> Register </button>
            </form>
            `
    }
}
