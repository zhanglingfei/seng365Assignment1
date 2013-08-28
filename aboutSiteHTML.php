<h3>Decision: allow class to access multiple database tables</h3>
<p>
I decided to access information from other database tables from a class for a particular table. 

I wished to allow the user to view orders by selecting which customer they wished to view the orders of and then selecting a particular order to view. The Orders table contains a foreign key customerId but this is not very useful information for the user at is it only an auto-incremented number. The customer's name is far more useful information, but this needs to be obtained from the Customers table. However, as the goal is to allow the user to view orders, displaying customers without any orders did not seem necessary and would just clutter up the selection box and potentially confuse a user. So I only wished to obtain only the names of customers who have orders. This involves using a multi-table sql query. As I do not need any other information from the customers table, and the query is being used for the order browser, I decided to put this query in the Orders class.
</p>
<p>
    About product browser
</p>
<p>
    About order browser
</p>