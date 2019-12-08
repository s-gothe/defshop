# Candyshop Shop Project

# functionality
- product listing (image, name, color, price net, price gross)
- filter products by color
- add products to basket
- (amount absichtlich weggelassen)
- basket listing  (image, name, color, price net, price gross)
- delete products from basket
- article count for cart
- buy more then one piece

# optimizations
- add .htacces file for change shown file ending from .php => .html
- add a new db table and model for the cart, with that it's easier to save a shop history
- normalize db seperate colors from product table
(for this a 2 new tables are nessesary to create a m:n relationship, also a new php model for colors should be created then)
