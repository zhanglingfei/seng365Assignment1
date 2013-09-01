<h2>To Do:</h2>
<p>
Fix this page (including adding info about actual code), documentation, comments, rename folder from Assignment 1 to classicmodels, acknowledge use of lab code, mysqli_real_escape_string and htmlspecialchars.
</p>

<p>
This site allows a user to view the details of a particular product offered by the Classic Models company, and to view the details of a particular order.
</p>
<p>
There are no known bugs and no important usage information for this site.
</p> 

<h3>Product Browser</h3>
<p>
The product browser allows a user to select a product line and then select a particular product in that product line to view the details of. The details give the product code, name, scale, vendor, a description of the product, and the quantity in stock, buy price, and MSRP.
</p>

<h3>Order Browser</h3>
<p>
The order browser allows a user to select a particular customer whose orders they wish to view, then select a particular order. The details of the order, such as the order date and shipping date are displayed, along with the lines of the order, giving the product name, quantity ordered, and price for each product ordered.
</p>

<h3>"id" columns in the database tables</h3>
<p>
None of the information displayed includes the id column from the database tables. The id column is simply an auto-incremented primary key for the table, and provides no useful information for a Classic Models employee. Instead, a more informative column, such as the product name, is displayed. 
</p>

<h3>Allowing classes to access multiple database tables</h3>
<p>
This is also the case for tables which include foreign keys such as customerId or productId, which simply reference the id column of the specified table. This is replaced by more useful information from the table it references, such as the name. In order to do this, I decided to access information in other database tables from a class for a particular table.
</p>
<p>
In the order browser, I wished to allow the user to view orders by selecting which customer they wished to view the orders of and then selecting a particular order to view. The Orders table contains a foreign key customerId but this is not very useful information for the user at is it only an auto-incremented number. The customer's name is far more useful information, but this needs to be obtained from the Customers table. Additionaly, as the goal is to allow the user to view orders, I decided that displaying customers without any orders was not necessary and would just clutter up the selection box and potentially confuse a user. So I wished to obtain only the names of customers who have placed orders. This involves using a multi-table sql query. As I do not need any other information from the customers table, and the query is being used for the order browser, I decided to put this query in the Orders class, accessing both the Orders and the Customers tables.
</p>

<h3>Order browser design</h3>
<p>
For each customer, I decided to list their orders by orderNumber as this is a unique reference to the order that provides more information than the auto-incremented id column of the Orders table. When an order is selected, the dates, status, and any comments are displayed. The id and customerId columns are not shown as the id columns do not provide useful information for the user and the customer's name is the one currently selected. 
All the lines of the selected order are also displayed. I decided to display all of the lines of the order at once rather than selecting a particular line to view as I thought this would be more useful for a user. There is not so much information for a particular order that it requires a filter to be a manageable amount of information to view at once, and I decided that seeing the entire order was easier for a user than having to switch between say 14 different lines using a select box.
</p>

<h3>Product browser design</h3>
<p>
group by productline
Persistence: I decided to provide persistence on the product browser page, so that if a user is viewing the details of a particular product, then goes to the order browser to look up an order, and then goes back to the product browser, they will still be viewing the same product.
</p>

<h3>Title and menu bar</h3>
<p>
Each page has a title and menu bar at the top. The title changes slightly based on which page is being viewed, but always begins with "Classic Models: " to provide some consistency between the pages. Each page also has a menu bar, which simply consists of a link to each page.
</p>
