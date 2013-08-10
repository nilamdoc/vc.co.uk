<?php use lithium\core\Environment; ?>
<li class="dropdown">
<a class="dropdown-toggle" data-toggle="dropdown" href="#">
	<?php foreach (Environment::get('locales') as $locale => $name): ?>
	<?php if($locale==Environment::get('locale')){print_r($name);break;}else{}?> 
	<?php if(substr(Environment::get('locale'),0,2)=="en"){echo "English";break;}?>	
	<?php endforeach; ?>

	<b class="caret"></b>
</a>
    <ul class="dropdown-menu">
        <?php foreach (Environment::get('locales') as $locale => $name): ?>
            <li><?=$this->html->link($name, compact('locale') + $this->_request->params); ?></li>
        <?php endforeach; ?>
    </ul>
</li>