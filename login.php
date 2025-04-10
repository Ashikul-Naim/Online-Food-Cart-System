<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Food Ordering System</title>
    <style>
        body {
			background-image : url('login.jpg');
            background-color: #f0f0f0; /* Background color */
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .container {
            background-color: Grey; /* Container background color */
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            position: Absolute; /* Make the container position relative */
        }

        .login-form {
            text-align: center;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .error-msg {
            color: red;
            margin-top: 10px;
        }

        h2 {
            font-weight: bold; /* Make the login title bold */
        }

        button[type="submit"] {
            background-color: #007bff; /* Blue color for the login button */
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        button[type="submit"]:hover {
            background-color: #0056b3; /* Darker blue color on hover */
        }
    </style>
</head>
<body>
    <div class="container">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" class="login-form">
            <h2>Login</h2>
            <?php if(isset($_GET['error']) && $_GET['error'] == 1) { ?>
                <div class="error-msg">Invalid username or password</div>
            <?php } ?>
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit">Login</button>
        </form>
    </div>

    import java.io.IOException;
import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.sql.SQLException;

import javax.servlet.ServletException;
import javax.servlet.annotation.WebServlet;
import javax.servlet.http.HttpServlet;
import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;
import javax.servlet.http.HttpSession;

@WebServlet("/LoginServlet")
public class LoginServlet extends HttpServlet {
    private static final long serialVersionUID = 1L;

    protected void doPost(HttpServletRequest request, HttpServletResponse response) throws ServletException, IOException {
        // Retrieve form data
        String username = request.getParameter("username");
        String password = request.getParameter("password");

        // Database connection parameters
        String dbUrl = "jdbc:mysql://localhost:3306/food_order";
        String dbUser = "root";
        String dbPassword = "";

        Connection conn = null;
        PreparedStatement stmt = null;
        ResultSet result = null;

        try {
            // Connect to the database
            Class.forName("com.mysql.cj.jdbc.Driver");
            conn = DriverManager.getConnection(dbUrl, dbUser, dbPassword);

            // Prepare and execute SQL query
            String sql = "SELECT * FROM customer WHERE Username=? AND Password=?";
            stmt = conn.prepareStatement(sql);
            stmt.setString(1, username);
            stmt.setString(2, password);
            result = stmt.executeQuery();

            // Check if user exists with the given credentials
            if (result.next()) {
                // Authentication successful, set session and redirect to restaurant page
                HttpSession session = request.getSession();
                session.setAttribute("username", result.getString("Username"));
                session.setAttribute("customer_id", result.getInt("Customer_id")); // Storing customer_id in session if needed
                response.sendRedirect("restaurant.jsp");
            } else {
                // Authentication failed, redirect back to login page with error message
                response.sendRedirect("login.jsp?error=1");
            }
        } catch (ClassNotFoundException | SQLException e) {
            e.printStackTrace();
            response.sendRedirect("login.jsp?error=1");
        } finally {
            // Close connections
            try {
                if (result != null) result.close();
                if (stmt != null) stmt.close();
                if (conn != null) conn.close();
            } catch (SQLException e) {
                e.printStackTrace();
            }
        }
    }
}


</body>
</html>

