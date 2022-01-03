package com.company;
import java.sql.*;

public class DBConnector {

    public static void main(String[] args) {

	    // write your code here
        try {
            Class.forName("com.mysql.cj.jdbc.Driver");
        } catch (ClassNotFoundException e) {
            System.out.println("MySQL JDBC Driver not found!");
            e.printStackTrace();
        }

        final String USERNAME = "root";
        final String PASSWORD = "projet123";
        final String DBNAME = "projetdb";
        final String URL = "jdbc:mysql://localhost:3306/" + DBNAME;

        System.out.println("Connecting to database");
        Connection connection;
        try {
            connection = DriverManager.getConnection(URL, USERNAME, PASSWORD);
        } catch (SQLException e) {
            System.out.println("Connection failed!");
            e.printStackTrace();
            return;
        }

        System.out.println("Connected successfully");
        Statement stmt;

        try {
            stmt = connection.createStatement();

            // Drop tables if they exist already
            System.out.println("Dropping tables");
            stmt.executeUpdate("DROP TABLE IF EXISTS has");
            stmt.executeUpdate("DROP TABLE IF EXISTS works_at");
            stmt.executeUpdate("DROP TABLE IF EXISTS works");
            stmt.executeUpdate("DROP TABLE IF EXISTS chosen_location");
            stmt.executeUpdate("DROP TABLE IF EXISTS contract");
            stmt.executeUpdate("DROP TABLE IF EXISTS transfer_pack");
            stmt.executeUpdate("DROP TABLE IF EXISTS submit_pack");
            stmt.executeUpdate("DROP TABLE IF EXISTS call_courier");
            stmt.executeUpdate("DROP TABLE IF EXISTS branch");
            stmt.executeUpdate("DROP TABLE IF EXISTS take");
            stmt.executeUpdate("DROP TABLE IF EXISTS send");
            stmt.executeUpdate("DROP TABLE IF EXISTS collect");
            stmt.executeUpdate("DROP TABLE IF EXISTS assign_to_employee");
            stmt.executeUpdate("DROP TABLE IF EXISTS assigns");
            stmt.executeUpdate("DROP TABLE IF EXISTS choose");
            stmt.executeUpdate("DROP TABLE IF EXISTS pickup_location");
            stmt.executeUpdate("DROP TABLE IF EXISTS report");
            stmt.executeUpdate("DROP TABLE IF EXISTS deliver");
            stmt.executeUpdate("DROP TABLE IF EXISTS evaluate");
            stmt.executeUpdate("DROP TABLE IF EXISTS employee");
            stmt.executeUpdate("DROP TABLE IF EXISTS company_representative");
            stmt.executeUpdate("DROP TABLE IF EXISTS send_to");
            stmt.executeUpdate("DROP TABLE IF EXISTS package");
            stmt.executeUpdate("DROP TABLE IF EXISTS courier_review");
            stmt.executeUpdate("DROP TABLE IF EXISTS courier");
            stmt.executeUpdate("DROP TABLE IF EXISTS customer");
            stmt.executeUpdate("DROP TABLE IF EXISTS user");
            stmt.executeUpdate("DROP PROCEDURE IF EXISTS get_user_type");

            // Create tables

            // User Table
            System.out.println("Creating tables");
            stmt.executeUpdate(
                    "CREATE TABLE user(" +
                            "user_ID    INT AUTO_INCREMENT," +
                            "username VARCHAR(50) NOT NULL UNIQUE," +
                            "password VARCHAR(50) NOT NULL," +
                            "email VARCHAR(50) NOT NULL UNIQUE," +
                            "phone VARCHAR(50) NOT NULL UNIQUE," +
                            "PRIMARY KEY (user_ID)" +
                            ");"
            );

            // ------------CREATE SECONDARY INDEX ON USER-----------
            //NEWLY ADDED!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
            stmt.executeUpdate("CREATE INDEX UserIndex ON user(username);");

            //customer Table
            stmt.executeUpdate(
                    "CREATE TABLE customer(" +
                            "customer_ID INT," +
                            "address VARCHAR(50) NOT NULL," +
                            "PRIMARY KEY (customer_ID)," +
                            "FOREIGN KEY (customer_ID) REFERENCES user(user_ID)" +
                            ");"
            );

            //courier Table
            stmt.executeUpdate(
                    "CREATE TABLE courier(" +
                            "courier_ID INT AUTO_INCREMENT," +
                            "salary INT," +
                            "price INT," +
                            "courier_type VARCHAR(50) NOT NULL," +
                            "PRIMARY KEY (courier_ID)," +
                            "FOREIGN KEY (courier_ID) REFERENCES user(user_ID)" +
                            ");"
            );

            //courier_review Table
            stmt.executeUpdate(
                    "CREATE TABLE courier_review(" +
                            "courier_ID INT," +
                            "review_ID INT AUTO_INCREMENT," +
                            "text VARCHAR(50) NOT NULL," +
                            "rate FLOAT," +
                            "PRIMARY KEY (review_ID)," +
                            "FOREIGN KEY (courier_ID) REFERENCES courier(courier_ID)" +
                            ");"
            );

            //package Table
            stmt.executeUpdate(
                    "CREATE TABLE package(" +
                            "package_ID INT AUTO_INCREMENT," +
                            "weight FLOAT," +
                            "dimension VARCHAR(50) NOT NULL," +
                            "delivery_address VARCHAR(50) NOT NULL," +
                            "status VARCHAR(50) NOT NULL," +
                            "send_time DATE NOT NULL," +
                            "delivery_time DATE NOT NULL," +
                            "package_type VARCHAR(50) NOT NULL," +
                            "courier_type VARCHAR(50)," +
                            "PRIMARY KEY (package_ID)" +
                            ");"
            );

            //send_to Table
            stmt.executeUpdate(
                    "CREATE TABLE send_to(" +
                            "sender_ID INT," +
                            "taker_ID INT," +
                            "package_ID INT," +
                            "PRIMARY KEY (sender_ID , taker_ID, package_ID)," +
                            "FOREIGN KEY (sender_ID) REFERENCES customer(customer_ID)," +
                            "FOREIGN KEY (package_ID) REFERENCES package(package_ID)," +
                            "FOREIGN KEY (taker_ID ) REFERENCES customer(customer_ID)" +
                            ");"
            );

            //company_representative Table
            stmt.executeUpdate(
                    "CREATE TABLE company_representative(" +
                            "company_ID INT," +
                            "company_name VARCHAR(50) NOT NULL," +
                            "PRIMARY KEY (company_ID)," +
                            "FOREIGN KEY (company_ID) REFERENCES user(user_ID)" +
                            ");"
            );

            //employee Table
            stmt.executeUpdate(
                    "CREATE TABLE employee(" +
                            "employee_ID INT," +
                            "salary INT," +
                            "PRIMARY KEY (employee_ID)," +
                            "FOREIGN KEY (employee_ID) REFERENCES user(user_ID)" +
                            ");"
            );

            //evaluate Table
            stmt.executeUpdate(
                    "CREATE TABLE evaluate(" +
                            "customer_ID INT," +
                            "courier_ID INT," +
                            "package_ID INT," +
                            "PRIMARY KEY (customer_ID, package_ID)," +
                            "FOREIGN KEY (customer_ID) REFERENCES customer(customer_ID)," +
                            "FOREIGN KEY (package_ID) REFERENCES package(package_ID)," +
                            "FOREIGN KEY (courier_ID ) REFERENCES courier(courier_ID)" +
                            ");"
            );

            //report Table
            stmt.executeUpdate(
                    "CREATE TABLE report(" +
                            "report_ID INT AUTO_INCREMENT," +
                            "customer_ID INT," +
                            "content VARCHAR(50) NOT NULL," +
                            "report_type VARCHAR(200) NOT NULL," +
                            "is_accepted VARCHAR(50) NOT NULL," +
                            "FOREIGN KEY (customer_ID) REFERENCES customer(customer_ID)," +
                            "PRIMARY KEY (report_ID, customer_ID)" +
                            ");"
            );

            //pickup_location Table
            stmt.executeUpdate(
                    "CREATE TABLE pickup_location(" +
                            "location_ID INT AUTO_INCREMENT," +
                            "location_name VARCHAR(50) NOT NULL," +
                            "address VARCHAR(50) NOT NULL," +
                            "phone VARCHAR(50) NOT NULL UNIQUE," +
                            "PRIMARY KEY (location_ID)" +
                            ");"
            );

            //assigns Table
            stmt.executeUpdate(
                    "CREATE TABLE assigns(" +
                            "package_ID INT," +
                            "courier_ID INT," +
                            "is_delivered VARCHAR(50) NOT NULL," +
                            "assigns_ID INT AUTO_INCREMENT," +
                            "PRIMARY KEY (assigns_ID)," +
                            "FOREIGN KEY (courier_ID) REFERENCES courier(courier_ID)," +
                            "FOREIGN KEY (package_ID) REFERENCES package(package_ID)" +
                            ");"
            );

            //assign_to Table
            stmt.executeUpdate(
                    "CREATE TABLE assign_to_employee(" +
                            "package_ID INT," +
                            "employee_ID INT," +
                            "is_accepted VARCHAR(50) NOT NULL," +
                            "PRIMARY KEY (package_ID)," +
                            "FOREIGN KEY (package_ID) REFERENCES package(package_ID)," +
                            "FOREIGN KEY (employee_ID) REFERENCES employee(employee_ID)" +
                            ");"
            );

            //branch Table
            stmt.executeUpdate(
                    "CREATE TABLE branch(" +
                            "branch_ID INT AUTO_INCREMENT," +
                            "address VARCHAR(50) NOT NULL," +
                            "phone VARCHAR(50) NOT NULL UNIQUE," +
                            "PRIMARY KEY (branch_ID)" +
                            ");"
            );

            //submit_pack Table
            stmt.executeUpdate(
                    "CREATE TABLE submit_pack(" +
                            "package_ID INT," +
                            "branch_ID INT," +
                            "PRIMARY KEY (package_ID)," +
                            "FOREIGN KEY (branch_ID) REFERENCES branch(branch_ID)," +
                            "FOREIGN KEY (package_ID) REFERENCES package(package_ID)" +
                            ");"
            );

            //transfer_pack Table
            stmt.executeUpdate(
                    "CREATE TABLE transfer_pack(" +
                            "package_ID INT," +
                            "branch_ID INT," +
                            "employee_ID INT," +
                            "transfer_ID INT AUTO_INCREMENT," +
                            "PRIMARY KEY (transfer_ID)," +
                            "FOREIGN KEY (branch_ID) REFERENCES branch(branch_ID)," +
                            "FOREIGN KEY (employee_ID) REFERENCES employee(employee_ID)," +
                            "FOREIGN KEY (package_ID) REFERENCES package(package_ID)" +
                            ");"
            );

            //contract Table
            stmt.executeUpdate(
                    "CREATE TABLE contract(" +
                            "company_ID INT," +
                            "branch_ID INT," +
                            "is_Approved VARCHAR(50) NOT NULL," +
                            "PRIMARY KEY (company_ID, branch_ID)," +
                            "FOREIGN KEY (branch_ID) REFERENCES branch(branch_ID)," +
                            "FOREIGN KEY (company_ID) REFERENCES company_representative(company_ID)" +
                            ");"
            );

            //chosen_location Table
            stmt.executeUpdate(
                    "CREATE TABLE chosen_location(" +
                            "location_ID INT," +
                            "branch_ID INT," +
                            "PRIMARY KEY (location_ID)," +
                            "FOREIGN KEY (branch_ID) REFERENCES branch(branch_ID)," +
                            "FOREIGN KEY (location_ID) REFERENCES pickup_location(location_ID)" +
                            ");"
            );

            //works Table
            stmt.executeUpdate(
                    "CREATE TABLE works(" +
                            "employee_ID INT," +
                            "branch_ID INT," +
                            "PRIMARY KEY (employee_ID)," +
                            "FOREIGN KEY (branch_ID) REFERENCES branch(branch_ID)," +
                            "FOREIGN KEY (employee_ID) REFERENCES employee(employee_ID)" +
                            ");"
            );

            //works_at Table
            stmt.executeUpdate(
                    "CREATE TABLE works_at(" +
                            "courier_ID INT," +
                            "branch_ID INT," +
                            "PRIMARY KEY (courier_ID)," +
                            "FOREIGN KEY (branch_ID) REFERENCES branch(branch_ID)," +
                            "FOREIGN KEY (courier_ID) REFERENCES courier(courier_ID)" +
                            ");"
            );

            //has Table
            stmt.executeUpdate(
                    "CREATE TABLE has(" +
                            "package_ID INT," +
                            "report_ID INT," +
                            "PRIMARY KEY (package_ID)," +
                            "FOREIGN KEY (report_ID) REFERENCES report(report_ID)," +
                            "FOREIGN KEY (package_ID) REFERENCES package(package_ID)" +
                            ");"
            );


            // ------STORED PROCEDURE FOR FINDING USER TYPE-----
            stmt.executeUpdate("CREATE PROCEDURE get_user_type(" + "IN user_ID INT" + ")"
                    + "SELECT user.user_ID, CASE WHEN(user.user_ID IN (SELECT customer.customer_ID FROM customer)) THEN 'customer' "
                    + "WHEN(user.user_ID IN (SELECT employee.employee_ID FROM employee)) THEN 'employee' "
                    + "WHEN(user.user_ID IN (SELECT company_representative.company_ID FROM company_representative)) THEN 'company_representative' "
                    + "WHEN(user.user_ID IN (SELECT courier.courier_ID FROM courier)) THEN 'courier' END AS user_type "
                    + "FROM user " + "WHERE user.user_ID = user_ID; ");


            stmt.executeUpdate("INSERT INTO user(username, password, email, phone) VALUES('utku_sezer', '123', 'utkus@gmail.com', '05439984328')");
            stmt.executeUpdate("INSERT INTO customer VALUES(LAST_INSERT_ID(),'bilkent camlık')");

            stmt.executeUpdate("INSERT INTO user(username, password, email, phone) VALUES('lara_fener', '123', 'laraf@gmail.com', '05439984323')");
            stmt.executeUpdate("INSERT INTO customer VALUES(LAST_INSERT_ID(),'besa karina')");

            stmt.executeUpdate("INSERT INTO user(username, password, email, phone) VALUES('ege_uyar', '123', 'egey@gmail.com', '05437684328')");
            stmt.executeUpdate("INSERT INTO customer VALUES(LAST_INSERT_ID(),'manisa havuz')");

            stmt.executeUpdate("INSERT INTO user(username, password, email, phone) VALUES('bilge_han', '123', 'bilgeh@gmail.com', '00939984323')");
            stmt.executeUpdate("INSERT INTO customer VALUES(LAST_INSERT_ID(),'nova cagdas')");

            //Initializing branches
            stmt.executeUpdate("INSERT INTO branch (address, phone) VALUES('bayirasagi', '312555555')");
            stmt.executeUpdate("INSERT INTO branch (address, phone) VALUES('cakirlar', '54679846')");
            stmt.executeUpdate("INSERT INTO branch (address, phone) VALUES('batikent', '12345675551')");
            stmt.executeUpdate("INSERT INTO branch (address, phone) VALUES('yasamkent', '989898898')");

            //Initializing pickup_location
            stmt.executeUpdate("INSERT INTO pickup_location (location_name, address, phone) VALUES('erdal bakkal', '9980 Linda St. Huntley, IL 60142', '310055555')");
            stmt.executeUpdate("INSERT INTO chosen_location (location_ID, branch_ID) VALUES(LAST_INSERT_ID(), 1)");

            stmt.executeUpdate("INSERT INTO pickup_location (location_name, address, phone) VALUES('bilkent ptt', '8794 Orange St.', '312059255')");
            stmt.executeUpdate("INSERT INTO chosen_location (location_ID, branch_ID) VALUES(LAST_INSERT_ID(), 1)");

            stmt.executeUpdate("INSERT INTO pickup_location (location_name, address, phone) VALUES('atasun optik', '7010 Bald Hill Drive', '312055855')");
            stmt.executeUpdate("INSERT INTO chosen_location (location_ID, branch_ID) VALUES(LAST_INSERT_ID(), 2)");

            stmt.executeUpdate("INSERT INTO pickup_location (location_name, address, phone) VALUES('alper bey dükkan', '135 East County Street', '312055509')");
            stmt.executeUpdate("INSERT INTO chosen_location (location_ID, branch_ID) VALUES(LAST_INSERT_ID(), 2)");

            stmt.executeUpdate("INSERT INTO pickup_location (location_name, address, phone) VALUES('82 çatı', '8998 Mill Road', '312055531')");
            stmt.executeUpdate("INSERT INTO chosen_location (location_ID, branch_ID) VALUES(LAST_INSERT_ID(), 2)");

            stmt.executeUpdate("INSERT INTO pickup_location (location_name, address, phone) VALUES('starbuks res bilkent', 'Silicon Valley Facebook 8392. Road', '312095555')");
            stmt.executeUpdate("INSERT INTO chosen_location (location_ID, branch_ID) VALUES(LAST_INSERT_ID(), 3)");

            stmt.executeUpdate("INSERT INTO pickup_location (location_name, address, phone) VALUES('nur eczane', 'Bilkent center kapı no 19', '312096555')");
            stmt.executeUpdate("INSERT INTO chosen_location (location_ID, branch_ID) VALUES(LAST_INSERT_ID(), 3)");

            stmt.executeUpdate("INSERT INTO pickup_location (location_name, address, phone) VALUES('merkez bankası', 'kızılay avm 4.kat 10A', '305055555')");
            stmt.executeUpdate("INSERT INTO chosen_location (location_ID, branch_ID) VALUES(LAST_INSERT_ID(), 4)");

            stmt.executeUpdate("INSERT INTO pickup_location (location_name, address, phone) VALUES('komagene çiköfte', 'bilkent 1 camlık site', '306055555')");
            stmt.executeUpdate("INSERT INTO chosen_location (location_ID, branch_ID) VALUES(LAST_INSERT_ID(), 4)");

            stmt.executeUpdate("INSERT INTO pickup_location (location_name, address, phone) VALUES('dost kitapevi', 'kızılay olgunlar 483.sokak', '305055444')");
            stmt.executeUpdate("INSERT INTO chosen_location (location_ID, branch_ID) VALUES(LAST_INSERT_ID(), 4)");

            //Initializing couriers
            stmt.executeUpdate("INSERT INTO user(username, password, email, phone) VALUES('ferat', '123', 'ferat@gmail.com', '05439784323')");
            stmt.executeUpdate("INSERT INTO courier VALUES(LAST_INSERT_ID(), 1000, 10, 'default_courier')");
            stmt.executeUpdate("INSERT INTO works_at VALUES(LAST_INSERT_ID(), 1)");

            stmt.executeUpdate("INSERT INTO user(username, password, email, phone) VALUES('pembe', '123', 'küpek@gmail.com', '03439284323')");
            stmt.executeUpdate("INSERT INTO courier VALUES(LAST_INSERT_ID(), 1000, 10, 'fast_courier')");
            stmt.executeUpdate("INSERT INTO works_at VALUES(LAST_INSERT_ID(), 1)");

            stmt.executeUpdate("INSERT INTO user(username, password, email, phone) VALUES('gökan', '123', 'tas@gmail.com', '05139284323')");
            stmt.executeUpdate("INSERT INTO courier VALUES(LAST_INSERT_ID(), 12000, 490, 'heavy_courier')");
            stmt.executeUpdate("INSERT INTO works_at VALUES(LAST_INSERT_ID(), 1)");

            stmt.executeUpdate("INSERT INTO user(username, password, email, phone) VALUES('aleyna', '123', 'futbol@gmail.com', '05039996323')");
            stmt.executeUpdate("INSERT INTO courier VALUES(LAST_INSERT_ID(), 6000, 50, 'fast_courier')");
            stmt.executeUpdate("INSERT INTO works_at VALUES(LAST_INSERT_ID(), 2)");

            stmt.executeUpdate("INSERT INTO user(username, password, email, phone) VALUES('götçe', '123', 'gök@gmail.com', '05095996323')");
            stmt.executeUpdate("INSERT INTO courier VALUES(LAST_INSERT_ID(), 43000, 10, 'default_courier')");
            stmt.executeUpdate("INSERT INTO works_at VALUES(LAST_INSERT_ID(), 2)");

            stmt.executeUpdate("INSERT INTO user(username, password, email, phone) VALUES('gizem', '123', 'giz@gmail.com', '05010996323')");
            stmt.executeUpdate("INSERT INTO courier VALUES(LAST_INSERT_ID(), 6000, 540, 'heavy_courier')");
            stmt.executeUpdate("INSERT INTO works_at VALUES(LAST_INSERT_ID(), 2)");

            stmt.executeUpdate("INSERT INTO user(username, password, email, phone) VALUES('erdemaga', '123', 'aga@gmail.com', '01039984323')");
            stmt.executeUpdate("INSERT INTO courier VALUES(LAST_INSERT_ID(), 10000, 10, 'default_courier')");
            stmt.executeUpdate("INSERT INTO works_at VALUES(LAST_INSERT_ID(), 3)");

            stmt.executeUpdate("INSERT INTO user(username, password, email, phone) VALUES('elif', '123', 'davas@gmail.com', '10039984323')");
            stmt.executeUpdate("INSERT INTO courier VALUES(LAST_INSERT_ID(), 10000, 10, 'heavy_courier')");
            stmt.executeUpdate("INSERT INTO works_at VALUES(LAST_INSERT_ID(), 3)");

            stmt.executeUpdate("INSERT INTO user(username, password, email, phone) VALUES('bedo', '123', 'konya@gmail.com', '09039984323')");
            stmt.executeUpdate("INSERT INTO courier VALUES(LAST_INSERT_ID(), 1000, 10, 'fast_courier')");
            stmt.executeUpdate("INSERT INTO works_at VALUES(LAST_INSERT_ID(), 3)");

            stmt.executeUpdate("INSERT INTO user(username, password, email, phone) VALUES('elon', '123', 'musk@gmail.com', '05329984323')");
            stmt.executeUpdate("INSERT INTO courier VALUES(LAST_INSERT_ID(), 4020, 50, 'heavy_courier')");
            stmt.executeUpdate("INSERT INTO works_at VALUES(LAST_INSERT_ID(), 4)");

            stmt.executeUpdate("INSERT INTO user(username, password, email, phone) VALUES('ziya', '123', 'hor@gmail.com', '05097984323')");
            stmt.executeUpdate("INSERT INTO courier VALUES(LAST_INSERT_ID(), 4000, 200, 'fast_courier')");
            stmt.executeUpdate("INSERT INTO works_at VALUES(LAST_INSERT_ID(), 4)");

            stmt.executeUpdate("INSERT INTO user(username, password, email, phone) VALUES('can', '123', 'kaz@gmail.com', '05099184323')");
            stmt.executeUpdate("INSERT INTO courier VALUES(LAST_INSERT_ID(), 400, 10, 'default_courier')");
            stmt.executeUpdate("INSERT INTO works_at VALUES(LAST_INSERT_ID(), 4)");

            //Initializing employees
            stmt.executeUpdate("INSERT INTO user(username, password, email, phone) VALUES('natasha', '123', 'nat@gmail.com', '05439784321')");
            stmt.executeUpdate("INSERT INTO employee VALUES(LAST_INSERT_ID(), 500)");
            stmt.executeUpdate("INSERT INTO works VALUES(LAST_INSERT_ID(), 1)");

            stmt.executeUpdate("INSERT INTO user(username, password, email, phone) VALUES('gönül', '123', 'neyseh@gmail.com', '01839784321')");
            stmt.executeUpdate("INSERT INTO employee VALUES(LAST_INSERT_ID(), 1500)");
            stmt.executeUpdate("INSERT INTO works VALUES(LAST_INSERT_ID(), 1)");

            stmt.executeUpdate("INSERT INTO user(username, password, email, phone) VALUES('nuri', '123', 'papacum@gmail.com', '05039984333')");
            stmt.executeUpdate("INSERT INTO employee VALUES(LAST_INSERT_ID(), 10000)");
            stmt.executeUpdate("INSERT INTO works VALUES(LAST_INSERT_ID(), 2)");

            stmt.executeUpdate("INSERT INTO user(username, password, email, phone) VALUES('haluk', '123', 'babababa@gmail.com', '05011984333')");
            stmt.executeUpdate("INSERT INTO employee VALUES(LAST_INSERT_ID(), 9000)");
            stmt.executeUpdate("INSERT INTO works VALUES(LAST_INSERT_ID(), 2)");

            stmt.executeUpdate("INSERT INTO user(username, password, email, phone) VALUES('cengiz', '123', 'hun@gmail.com', '02039984333')");
            stmt.executeUpdate("INSERT INTO employee VALUES(LAST_INSERT_ID(), 10600)");
            stmt.executeUpdate("INSERT INTO works VALUES(LAST_INSERT_ID(), 2)");

            stmt.executeUpdate("INSERT INTO user(username, password, email, phone) VALUES('alex', '123', 'a@gmail.com', '05049784321')");
            stmt.executeUpdate("INSERT INTO employee VALUES(LAST_INSERT_ID(), 50040)");
            stmt.executeUpdate("INSERT INTO works VALUES(LAST_INSERT_ID(), 3)");

            stmt.executeUpdate("INSERT INTO user(username, password, email, phone) VALUES('ferman', '123', 'akgul@gmail.com', '05010084321')");
            stmt.executeUpdate("INSERT INTO employee VALUES(LAST_INSERT_ID(), 540)");
            stmt.executeUpdate("INSERT INTO works VALUES(LAST_INSERT_ID(), 3)");

            stmt.executeUpdate("INSERT INTO user(username, password, email, phone) VALUES('deivid', '123', 'devil@gmail.com', '09039984333')");
            stmt.executeUpdate("INSERT INTO employee VALUES(LAST_INSERT_ID(), 6000)");
            stmt.executeUpdate("INSERT INTO works VALUES(LAST_INSERT_ID(), 4)");

            stmt.executeUpdate("INSERT INTO user(username, password, email, phone) VALUES('hakan', '123', 'hak@gmail.com', '09038984333')");
            stmt.executeUpdate("INSERT INTO employee VALUES(LAST_INSERT_ID(), 6000)");
            stmt.executeUpdate("INSERT INTO works VALUES(LAST_INSERT_ID(), 4)");

            stmt.executeUpdate("INSERT INTO user(username, password, email, phone) VALUES('ali', '123', 'agaoglu@gmail.com', '99939984323')");
            stmt.executeUpdate("INSERT INTO company_representative VALUES(LAST_INSERT_ID(), 'stanley cmp.')");

            stmt.executeUpdate("INSERT INTO user(username, password, email, phone) VALUES('john', '123', 'jk@gmail.com', '89939984323')");
            stmt.executeUpdate("INSERT INTO company_representative VALUES(LAST_INSERT_ID(), 'pull&bear')");

            stmt.executeUpdate("INSERT INTO user(username, password, email, phone) VALUES('cagla', '123', 'şikel@gmail.com', '83939984323')");
            stmt.executeUpdate("INSERT INTO company_representative VALUES(LAST_INSERT_ID(), 'adl tekstil')");

        } catch (SQLException e) {
            System.out.println("SQLException: " + e.getMessage());
            e.printStackTrace();
        }

    }
}
