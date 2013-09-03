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

<h3>Title and menu bar</h3>
<p>
Each page has a title and menu bar at the top. The title changes slightly based on which page is being viewed, but always begins with "Classic Models: " to provide some consistency between the pages. Each page also has a menu bar, which simply consists of a link to each page.
</p>

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
I created classes for product lines, products, orders, and order details. These classes provide a level of abstraction for accessing the information in the corresponding table of the database. Each class provides a read function which takes an id and returns an object of the class corresponding to that row of the table, with the value in each column stored as an attribute of the object. The classes also contain various other functions which return the information required by particular parts of the website such as the combo boxes and tables.
<br>
I decided to allow classes to access multiple database tables.
Some of the tables in the database contain foreign keys which reference the id column of another table. The id is not very informative for the user, so it makes sense to replace this with other information from the referenced table. This is most easily achieved using a multi-table sql query, where the exact information required is simply requested from the database. This is far simpler than obtaining the information from another model (and possibly having to create a new model first), and then dealing with two sets of information to take parts of and display. Additionally, in the order browser, I wished to only display the names of customers who have placed orders. This also requires a multi-table sql query. The most logical place for this query seemed to be in the orders class since the information is to be used in the order browser.
Due to both of these situations, I decided to allow classes to access multiple database tables.
<br>
<br>
JSON files:
</p>

<h3>html</h3>
<p>
As each file's html has a very similar title and menu, I have placed this in a separate file, which uses a variable $title. This file, headerHTML.php, must be included before the file containing the rest of the html for the page, which must also close the body and head tags at the end. This allows for non-repetitive code and the header could easily be changed for all files to keep it consistent (or changed for a single file if necessary by not including the file and writing it at the beginning of the main html file for that page.
</p>

<p>
As I do not need any other information from the customers table, and the query is being used for the order browser, I decided to put this query in the Orders class, accessing both the Orders and the Customers tables.
</p>


