<h2>To Do:</h2>
<p>
Fix this page (including adding info about actual code), documentation, comments, rename folder from Assignment 1 to classicmodels, acknowledge use of lab code, mysqli_real_escape_string and htmlspecialchars.
</p>

<p>
This site allows a user to view the details of the products offered by the Classic Models company, and to view the details of customers' orders.
<br>
The product browser allows a user to select a product line and then select a particular product in that line. The details of the product are then shown in a table. 
<br>
The order browser allows a user to select a particular customer and then select an order to view. The details of the order and all the lines of the order are then displayed in two tables.
</p>

<p>
There are no known bugs and no important usage information for this site.
</p> 

<h2>Implementation and Design Decisions</h2>

<h3>Product Browser</h3>
<p>
The product browser has been implemented using a postback pattern. JavaScript has only been used for two simple event handlers, to take note of which combo box was changed and then submit the form. 
<br>
A session variable has been used to keep track of the most recent product and product line viewed. This allows the user to change pages, say to view an order, then go to the product browser again and still be viewing the details of the same product.
<br>
When the page is submitted, the postback uses the values of the POST variables and the SESSION variables to determine which product's details to display.
</p>

<h3>Order Browser</h3>
<p>
The order browser has a more JavaScript-oriented implementation. The combo boxes and tables are populated using AJAX, with JSON-encoded data.
<br>
As this page is an order browser, I decided not to include customers without any orders as that could potentially confuse users and also significantly increase the number of entries in the combo box without providing any more information about orders which have been placed.
<br>
I also decided to display all of the lines of the order at once rather than selecting a particular line to view. I decided that seeing the entire order would be easier for a user than having to switch between multiple different order lines (of which there might be quite a few).
</p>

<h3>Models</h3>
<p>
I created classes for product lines, products, orders, and order details. These classes provide a level of abstraction for accessing the information in the database. Each class provides a read function which takes the id of a particular row of the corresponding table and returns an object of the class corresponding to that row, with each column as an attribute of the object. The classes also contain various other functions which return the information required by particular parts of the website.
<br>
access multiple tables...
<br>
JSON files
</p>

<h3>html</h3>
<p>
As each file's html has a very similar title and menu, I have placed this in a separate file, which uses a variable $title. This file, headerHTML.php, must be included before the file containing the rest of the html for the page, which must also close the body and head tags at the end. This allows for non-repetitive code and the header could easily be changed for all files to keep it consistent (or changed for a single file if necessary by not including the file and writing it at the beginning of the main html file for that page.
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
