<!-- Side Nav START -->
<div class="side-nav">
	<div class="side-nav-inner">
		<ul class="side-nav-menu scrollable">
			<?php
				$setting = $this->db->get_where('tbl_setting',array('nama_setting'=>'Tampil Menu'))->row_array();
				$id_user_level = $this->session->userdata('id_user_level');
				if($setting["value"]=="ya"){
					$this->db->where("id_menu in(select id_menu from tbl_hak_akses where id_user_level=$id_user_level) and is_main_menu=0 and is_aktif='y'");
				}else{
					$this->db->where("is_aktif='y' and is_main_menu=0");
				}
				$this->db->order_by("title` ASC");
				$main_menu = $this->db->get("tbl_menu");
				
				$menu_html = function($menu, $multi=false) {
					return '<li class="nav-item '.($multi?'dropdown':'').'">
						<a class="dropdown-toggle" href="'.($multi?'javascript:void(0)':base_url(strtolower($menu->url))).'">
							<span class="icon-holder">
								<i class="'.$menu->icon.'"></i>
							</span>
							<span class="title">'.strtoupper($menu->title).'</span>'.
							($multi?'<span class="arrow"><i class="arrow-icon"></i></span>':'').
						'</a>';
				};
				if($main_menu->num_rows()>0){
					$main_menu = $main_menu->result();
					foreach ($main_menu as $menu){
						$this->db->where("id_menu in(select id_menu from tbl_hak_akses where id_user_level=$id_user_level)");
						$submenu = $this->db->get_where('tbl_menu',['is_main_menu'=>$menu->id_menu,'is_aktif'=>'y']);
						if($submenu->num_rows()>0){
							$data = $menu_html($menu, true).'<ul class="dropdown-menu">';
							foreach ($submenu->result() as $sub){
								$this->db->where("id_menu in(select id_menu from tbl_hak_akses where id_user_level=$id_user_level)");
								$tmenu = $this->db->get_where('tbl_menu',['is_main_menu'=>$sub->id_menu,'is_aktif'=>'y']);
								if($tmenu->num_rows()>0){
									$data .= $menu_html($sub, true).'<ul class="dropdown-menu">';
									foreach ($tmenu->result() as $tsub){
										$data .= "<li>".anchor(strtolower($sub->url).'/'.strtolower($tsub->url),strtoupper($tsub->title))."</li>";
									}
									$data .= "</ul></li>";
								} else {
									$data .= "<li>".anchor(strtolower($sub->url),strtoupper($sub->title))."</li>";
								}							
							}
							$data .= "</ul></li>";
						} else {
							$data = $menu_html($menu)."</li>";
						}
						echo $data;
					}
				}
			?>
		</ul>
	</div>
</div>
<!-- Side Nav END -->