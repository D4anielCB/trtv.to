<?php

ob_start();
echo 'a';
print 'b';

//some statement that removes all printedechoed items
ob_end_clean();

echo 'c';

//the final output is equal to 'c', not 'abc'

