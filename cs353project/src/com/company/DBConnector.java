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

        final String USERNAME = "";
        final String PASSWORD = "";
        final String DBNAME = "";
        final String URL = "jdbc:mysql://dijkstra.ug.bcc.bilkent.edu.tr/" + DBNAME;

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
            stmt.executeUpdate("DROP TABLE IF EXISTS user");
            stmt.executeUpdate("DROP TABLE IF EXISTS customer");
            stmt.executeUpdate("DROP TABLE IF EXISTS courier");
            stmt.executeUpdate("DROP TABLE IF EXISTS send_to");
            stmt.executeUpdate("DROP TABLE IF EXISTS company_representative");
            stmt.executeUpdate("DROP TABLE IF EXISTS employee");
            stmt.executeUpdate("DROP TABLE IF EXISTS evaluate");
            stmt.executeUpdate("DROP TABLE IF EXISTS deliver");
            stmt.executeUpdate("DROP TABLE IF EXISTS report");
            stmt.executeUpdate("DROP TABLE IF EXISTS choose");
            stmt.executeUpdate("DROP TABLE IF EXISTS assigns");
            stmt.executeUpdate("DROP TABLE IF EXISTS assign_to_employee");
            stmt.executeUpdate("DROP TABLE IF EXISTS collect");
            stmt.executeUpdate("DROP TABLE IF EXISTS package");
            stmt.executeUpdate("DROP TABLE IF EXISTS send");
            stmt.executeUpdate("DROP TABLE IF EXISTS take");
            stmt.executeUpdate("DROP TABLE IF EXISTS call_courier");
            stmt.executeUpdate("DROP TABLE IF EXISTS pickup_location");
            stmt.executeUpdate("DROP TABLE IF EXISTS submit_pack");
            stmt.executeUpdate("DROP TABLE IF EXISTS transfer_pack");
            stmt.executeUpdate("DROP TABLE IF EXISTS branch");
            stmt.executeUpdate("DROP TABLE IF EXISTS contract");
            stmt.executeUpdate("DROP TABLE IF EXISTS chosen_location");
            stmt.executeUpdate("DROP TABLE IF EXISTS works");
            stmt.executeUpdate("DROP TABLE IF EXISTS works_at");
            stmt.executeUpdate("DROP TABLE IF EXISTS has");

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
                            "PRIMARY KEY (courier_ID)" +
                            "FOREIGN KEY (courier_ID) REFERENCES user(user_ID)" +
                            ");"
            );

            //courier_review Table
            stmt.executeUpdate(
                    "CREATE TABLE courier_review(" +
                            "courier_ID INT," +
                            "review_ID INT," +
                            "text VARCHAR(50) NOT NULL," +
                            "rate FLOAT" +
                            "PRIMARY KEY (courier_ID, review_ID)," +
                            "FOREIGN KEY (courier_ID ) REFERENCES user(user_ID)" +
                            ");"
            );

            //send_to Table
            stmt.executeUpdate(
                    "CREATE TABLE send_to(" +
                            "sender_ID INT," +
                            "taker_ID INT," +
                            "PRIMARY KEY (sender_ID , taker_ID)," +
                            "FOREIGN KEY (sender_ID) REFERENCES customer(customer_ID)," +
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
                            "PRIMARY KEY (customer_ID, report_ID, package_ID)," +
                            "FOREIGN KEY (customer_ID) REFERENCES customer (customer_ID)" +
                            "FOREIGN KEY (package_ID) REFERENCES package(package_ID)" +
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

            //assign_to Table bitmedi
            stmt.executeUpdate(
                    "CREATE TABLE assign_to_employee(" +
                            "package_ID INT," +
                            "employee_ID INT," +
                            "is_accepted VARCHAR(50) NOT NULL," +
                            "PRIMARY KEY (customer_ID, report_ID, package_ID)," +
                            "FOREIGN KEY (customer_ID) REFERENCES customer (customer_ID)" +
                            "FOREIGN KEY (package_ID) REFERENCES package(package_ID);" +
                            ");"
            );

            //collect Table ***********************************DÜZELT
            stmt.executeUpdate(
                    "CREATE TABLE collect(" +
                            "package_ID INT," +
                            "employee_ID INT," +
                            "is_accepted VARCHAR(50) NOT NULL," +
                            "report_type VARCHAR(50) NOT NULL," +
                            "is_accepted VARCHAR(50) NOT NULL," +
                            "PRIMARY KEY (customer_ID, report_ID, package_ID)," +
                            "FOREIGN KEY (customer_ID) REFERENCES customer (customer_ID)" +
                            "FOREIGN KEY (package_ID) REFERENCES package(package_ID);" +
                            ");"
            );

            //package Table

            //send Table

            //take Table

            //call_courier Table

            //pickup_location Table

            //submit_pack Table

            //transfer_pack Table

            //branch Table

            //contract Table

            //chosen_location Table

            //works Table

            //works_at Table

            //has Table


        } catch (SQLException e) {
            System.out.println("SQLException: " + e.getMessage());
            e.printStackTrace();
        }

    }
}
