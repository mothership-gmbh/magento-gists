# Find out all loaded blocks

Open any view, for example: root/../catalog/product/list.phtml and paste in the following snippet to get a list of all loaded blocks

```
print_r(Mage::app()->getLayout()->getAllBlocks());
```
