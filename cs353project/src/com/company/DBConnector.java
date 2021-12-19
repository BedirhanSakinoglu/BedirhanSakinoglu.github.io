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
                            "review_ID INT," +
                            "text VARCHAR(50) NOT NULL," +
                            "rate FLOAT," +
                            "PRIMARY KEY (courier_ID, review_ID)," +
                            "FOREIGN KEY (courier_ID) REFERENCES user(user_ID)" +
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
                            "courier_type INT," +
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
                            "FOREIGN KEY (company_ID ) REFERENCES user(user_ID)" +
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
                            "rating INT," +
                            "text VARCHAR(50) NOT NULL," +
                            "PRIMARY KEY (customer_ID)," +
                            "FOREIGN KEY (customer_ID) REFERENCES customer(customer_ID)," +
                            "FOREIGN KEY (courier_ID ) REFERENCES courier(courier_ID)" +
                            ");"
            );

            //deliver Table
            stmt.executeUpdate(
                    "CREATE TABLE deliver(" +
                            "customer_ID INT," +
                            "courier_ID INT," +
                            "PRIMARY KEY (customer_ID, courier_ID)," +
                            "FOREIGN KEY (customer_ID) REFERENCES customer(customer_ID)," +
                            "FOREIGN KEY (courier_ID ) REFERENCES courier(courier_ID)" +
                            ");"
            );

            //report Table
            stmt.executeUpdate(
                    "CREATE TABLE report(" +
                            "report_ID INT AUTO_INCREMENT," +
                            "customer_ID INT," +
                            "package_ID  INT," +
                            "content VARCHAR(50) NOT NULL," +
                            "report_type VARCHAR(50) NOT NULL," +
                            "is_accepted VARCHAR(50) NOT NULL," +
                            "FOREIGN KEY (customer_ID) REFERENCES customer(customer_ID)," +
                            "PRIMARY KEY (report_ID)" +
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

            //choose Table
            stmt.executeUpdate(
                    "CREATE TABLE choose(" +
                            "customer_ID INT," +
                            "location_ID INT," +
                            "PRIMARY KEY (customer_ID)," +
                            "FOREIGN KEY (customer_ID) REFERENCES customer (customer_ID)," +
                            "FOREIGN KEY (location_ID) REFERENCES pickup_location (location_ID)" +
                            ");"
            );


            //assigns Table
            stmt.executeUpdate(
                    "CREATE TABLE assigns(" +
                            "package_ID INT," +
                            "courier_ID INT," +
                            "is_delivered VARCHAR(50) NOT NULL," +
                            "PRIMARY KEY (package_ID)," +
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

            //collect Table
            stmt.executeUpdate(
                    "CREATE TABLE collect(" +
                            "package_ID INT," +
                            "courier_ID INT," +
                            "PRIMARY KEY (package_ID)," +
                            "FOREIGN KEY (package_ID) REFERENCES package(package_ID)," +
                            "FOREIGN KEY (courier_ID) REFERENCES courier(courier_ID)" +
                            ");"
            );

            //send Table
            stmt.executeUpdate(
                    "CREATE TABLE send(" +
                            "package_ID INT," +
                            "customer_ID INT," +
                            "PRIMARY KEY (package_ID)," +
                            "FOREIGN KEY (customer_ID) REFERENCES customer(customer_ID)," +
                            "FOREIGN KEY (package_ID) REFERENCES package(package_ID)" +
                            ");"
            );

            //take Table
            stmt.executeUpdate(
                    "CREATE TABLE take(" +
                            "package_ID INT," +
                            "customer_ID INT," +
                            "PRIMARY KEY (package_ID)," +
                            "FOREIGN KEY (customer_ID) REFERENCES customer(customer_ID)," +
                            "FOREIGN KEY (package_ID) REFERENCES package(package_ID)" +
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

            //call_courier Table
            stmt.executeUpdate(
                    "CREATE TABLE call_courier(" +
                            "courier_ID INT," +
                            "branch_ID INT," +
                            "customer_ID INT," +
                            "PRIMARY KEY (courier_ID, branch_ID)," +
                            "FOREIGN KEY (courier_ID) REFERENCES courier(courier_ID)," +
                            "FOREIGN KEY (branch_ID) REFERENCES branch(branch_ID )," +
                            "FOREIGN KEY (customer_ID) REFERENCES customer(customer_ID)" +
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
                            "PRIMARY KEY (package_ID)," +
                            "FOREIGN KEY (branch_ID) REFERENCES branch(branch_ID)," +
                            "FOREIGN KEY (employee_ID) REFERENCES employee(employee_ID)," +
                            "FOREIGN KEY (package_ID) REFERENCES package(package_ID)" +
                            ");"
            );

            //contract Table
            stmt.executeUpdate(
                    "CREATE TABLE contract(" +
                            "package_ID INT," +
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

            stmt.executeUpdate("INSERT INTO user(username, password, email, phone) VALUES('utku_sezer', '123', 'utkus@gmail.com', '05439984328')");
            stmt.executeUpdate("INSERT INTO customer VALUES(LAST_INSERT_ID(),'bilkent camlık')");
            stmt.executeUpdate("INSERT INTO user(username, password, email, phone) VALUES('lara_fener', '123', 'laraf@gmail.com', '05439984323')");
            stmt.executeUpdate("INSERT INTO customer VALUES(LAST_INSERT_ID(),'yasamkent karina')");

            stmt.executeUpdate("INSERT INTO user(username, password, email, phone) VALUES('ege_uyar', '233', 'egey@gmail.com', '05437684328')");
            stmt.executeUpdate("INSERT INTO customer VALUES(LAST_INSERT_ID(),'manisa havuz')");
            stmt.executeUpdate("INSERT INTO user(username, password, email, phone) VALUES('bilge_han', '4993', 'bilgeh@gmail.com', '00939984323')");
            stmt.executeUpdate("INSERT INTO customer VALUES(LAST_INSERT_ID(),'yasamkent cagdas')");

            stmt.executeUpdate("INSERT INTO package(weight, status, send_time, package_type, dimension, delivery_address, delivery_time, courier_type) VALUES(35.5, 'Not delivered', DATE '2015-12-17' ,'spoilable','30x30x43','hamamönü', DATE '2015-12-31',0)");
            stmt.executeUpdate("INSERT INTO send_to(sender_ID, taker_ID, package_ID) VALUES(1,2, LAST_INSERT_ID())");

            stmt.executeUpdate("INSERT INTO package(weight, status, send_time, package_type, dimension, delivery_address, delivery_time, courier_type) VALUES(32.1, 'Not delivered', DATE '2015-12-17' ,'spoilable','30x10x43','izmir', DATE '2010-12-31',0)");
            stmt.executeUpdate("INSERT INTO send_to(sender_ID, taker_ID, package_ID) VALUES(1,2,LAST_INSERT_ID())");

            stmt.executeUpdate("INSERT INTO package(weight, status, send_time, package_type, dimension, delivery_address, delivery_time, courier_type) VALUES(10, 'Not delivered', DATE '2012-01-17' ,'fragile','10x30x43','bilkent', DATE '2019-12-31',0)");
            stmt.executeUpdate("INSERT INTO send_to(sender_ID, taker_ID, package_ID) VALUES(2,1,LAST_INSERT_ID())");

            stmt.executeUpdate("INSERT INTO package(weight, status, send_time, package_type, dimension, delivery_address, delivery_time, courier_type) VALUES(100, 'Not delivered', DATE '2010-01-17' ,'spoiled','10x10x43','karacaahmet', DATE '2019-12-31',0)");
            stmt.executeUpdate("INSERT INTO send_to(sender_ID, taker_ID, package_ID) VALUES(2,1,LAST_INSERT_ID())");

            stmt.executeUpdate("INSERT INTO package(weight, status, send_time, package_type, dimension, delivery_address, delivery_time, courier_type) VALUES(9.5, 'Not delivered', DATE '2020-01-17' ,'box','10x57x43','selcuk efes', DATE '2020-12-31',0)");
            stmt.executeUpdate("INSERT INTO send_to(sender_ID, taker_ID, package_ID) VALUES(3,1,LAST_INSERT_ID())");

            stmt.executeUpdate("INSERT INTO package(weight, status, send_time, package_type, dimension, delivery_address, delivery_time, courier_type) VALUES(90.5, 'Not delivered', DATE '2020-01-17' ,'fragile','10x57x43','77 yurt', DATE '2020-12-31',0)");
            stmt.executeUpdate("INSERT INTO send_to(sender_ID, taker_ID, package_ID) VALUES(1,4,LAST_INSERT_ID())");

        } catch (SQLException e) {
            System.out.println("SQLException: " + e.getMessage());
            e.printStackTrace();
        }

    }
}
