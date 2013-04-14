<li <?php if($this->uri->segment(3)=='weapons'){ ?>class="active"<?php } ?>><a href="<?=base_url('editor/items/weapons')?>">Weapons</a></li>
<li <?php if($this->uri->segment(3)=='armor'){ ?>class="active"<?php } ?>><a href="<?=base_url('editor/items/armor')?>">Armor</a></li>
<li <?php if($this->uri->segment(3)=='shields'){ ?>class="active"<?php } ?>><a href="<?=base_url('editor/items/shields')?>">Shields</a></li>
<li <?php if($this->uri->segment(3)=='amulets'){ ?>class="active"<?php } ?>><a href="<?=base_url('editor/items/amulets')?>">Amulets</a></li>
<li <?php if($this->uri->segment(3)=='relics'){ ?>class="active"<?php } ?>><a href="<?=base_url('editor/items/relics')?>">Relics</a></li>
<li <?php if($this->uri->segment(3)=='consumables'){ ?>class="active"<?php } ?>><a href="<?=base_url('editor/items/consumables')?>">Consumables</a></li>
<li <?php if($this->uri->segment(3)=='rings'){ ?>class="active"<?php } ?>><a href="<?=base_url('editor/items/rings')?>">Rings</a></li>