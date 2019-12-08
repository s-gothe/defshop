# defshop




Normalerweise würde ich Farben noch in der DB normalisieren und in eine extra Tabelle mit einer m:n Beziehung packen und dafür ein extra model erzeugen, aber aufgrund der größe des Projektes habe ich bewußt darauf verzichtet

Der Warenkorb hätte ebenfalls über eine DB Tabelle gelöst werden können, so das die Einkäufe auch für später als History gespeichert woden wären.


# functionality

- product listing (image, name, color, price net, price gross)
- filter products by color
- add products to basket
- (amount absichtlich weggelassen)
- basket listing  (image, name, color, price net, price gross)
- delete products from basket
- article count for basket
