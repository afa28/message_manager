<?php
/** Generate by crud generator model pada 2020-04-09 13:27:27
*   Author afandi
*/
class Menu_model extends MY_Model{
    protected $_table = 'menus';
    protected $has_many = ['menu_permission' => ['primary_key' => 'menu_id', 'model' => 'menu_permission_permission_model']];
    protected $primary_key = 'id';
    /** this data shown on main table
     *  if your table having foreign key, you can get data on reference column
     *  by references_table.column   
     */
    protected $columnTableData = ['menus.id','menus.name','menus.description','menus.status','concat(\'<i class="fa \',menus.icon,\'"></i>\') as icon','menus.route','p.name as parent'];
    protected $headerTableData = [
        [['data' => 'name'],['data' => 'description'],['data' => 'status'],['data' => 'icon'],['data' => 'route'],['data' => 'parent_id']]    
    ];
    
	private $withMenus = FALSE;
	protected $before_get = array('joinMenus');		
	public function joinMenus()
	{
		if($this->getWithMenus()){
			$this->_database->join('menus as p', 'p.id = menus.parent_id','left');				
		}
	}
	/**
	 * Get the value of withMenus
	 */ 
	public function getWithMenus()
	{
		return $this->withMenus;
	}
	/**
	 * Set the value of withMenus
	 *
	 * @return  self
	 */ 
	public function setWithMenus($withMenus)
	{
		$this->withMenus = $withMenus;
		return $this;
	}
    protected $form = [		
		'parent_id' => [
			'id' => 'parent_id',
			'name' => 'parent_id',
			'type' => 'dropdown',
            'label' => 'parent_id',
            'rules' => '',            
			'options' => [],
            'class' => 'select2_single',                 
        ],		
		'name' => [
			'id' => 'name',
			'name' => 'name',
			'type' => 'input',
            'label' => 'name',
			'rules' => 'required|max:100',
			//'style' => 'max-width: 50px'                                  
        ],		
		'description' => [
			'id' => 'description',
			'name' => 'description',
			'type' => 'textarea',
            'label' => 'description',
            'rules' => 'max:100',
            'rows' => 2
			                 
        ],		
		'status' => [
			'id' => 'status',
			'name' => 'status',
            'type' => 'dropdown',
            'options' => ['1' => 'Aktif', '0' => 'Non Aktif'],
            'label' => 'status',
            'rules' => 'required|max:1',
            'class' => 'select2_single',                 
			                 
        ],		
		'icon' => [
			'id' => 'icon',
			'name' => 'icon',
            'type' => 'dropdown',
            'options' => [],
            'label' => 'icon',
			'rules' => 'max:50',
            'class' => 'select2_single',                 
        ],		
		'route' => [
			'id' => 'route',
			'name' => 'route',
            'type' => 'input',
            'placeholder' => 'can empty if used as label menu',
            'label' => 'route',
			'rules' => 'max:100',
			                 
        ],
		'submit' => [
            'id' => 'submit',
            'type' => 'submit',
            'label' => 'Simpan'
        ]];
    
    /** function ini untuk memberikan nilai default form,
      * misalkan mengisi data pilihan dropdown dari database dll */
    protected function setOptionDataForm($where = array()){
        parent::setOptionDataForm($where);
        
		$this->load->model('menu_model','fk_parent_id');
		/* adjust second parameter on function dropdown with your column name to show in dropdown */
		$dataFk_parent_id = $this->fk_parent_id->dropdown('id','name');
        $this->form['parent_id']['options'] = $dataFk_parent_id;
        $this->form['icon']['options'] = $this->listICon();
    }

    private function listICon()
    {
        return [
            'fa-address-book'=> 'fa-address-book',
            'fa-address-book-o'=> 'fa-address-book-o',
            'fa-address-card'=> 'fa-address-card',
            'fa-address-card-o'=> 'fa-address-card-o',
            'fa-adjust'=> 'fa-adjust',
            'fa-adn'=> 'fa-adn',
            'fa-align-center'=> 'fa-align-center',
            'fa-align-justify'=> 'fa-align-justify',
            'fa-align-left'=> 'fa-align-left',
            'fa-align-right'=> 'fa-align-right',
            'fa-amazon'=> 'fa-amazon',
            'fa-ambulance'=> 'fa-ambulance',
            'fa-american-sign-language-interpreting'=> 'fa-american-sign-language-interpreting',
            'fa-anchor'=> 'fa-anchor',
            'fa-android'=> 'fa-android',
            'fa-angellist'=> 'fa-angellist',
            'fa-angle-double-down'=> 'fa-angle-double-down',
            'fa-angle-double-left'=> 'fa-angle-double-left',
            'fa-angle-double-right'=> 'fa-angle-double-right',
            'fa-angle-double-up'=> 'fa-angle-double-up',
            'fa-angle-down'=> 'fa-angle-down',
            'fa-angle-left'=> 'fa-angle-left',
            'fa-angle-right'=> 'fa-angle-right',
            'fa-angle-up'=> 'fa-angle-up',
            'fa-apple'=> 'fa-apple',
            'fa-archive'=> 'fa-archive',
            'fa-area-chart'=> 'fa-area-chart',
            'fa-arrow-circle-down'=> 'fa-arrow-circle-down',
            'fa-arrow-circle-left'=> 'fa-arrow-circle-left',
            'fa-arrow-circle-o-down'=> 'fa-arrow-circle-o-down',
            'fa-arrow-circle-o-left'=> 'fa-arrow-circle-o-left',
            'fa-arrow-circle-o-right'=> 'fa-arrow-circle-o-right',
            'fa-arrow-circle-o-up'=> 'fa-arrow-circle-o-up',
            'fa-arrow-circle-right'=> 'fa-arrow-circle-right',
            'fa-arrow-circle-up'=> 'fa-arrow-circle-up',
            'fa-arrow-down'=> 'fa-arrow-down',
            'fa-arrow-left'=> 'fa-arrow-left',
            'fa-arrow-right'=> 'fa-arrow-right',
            'fa-arrow-up'=> 'fa-arrow-up',
            'fa-arrows'=> 'fa-arrows',
            'fa-arrows-alt'=> 'fa-arrows-alt',
            'fa-arrows-h'=> 'fa-arrows-h',
            'fa-arrows-v'=> 'fa-arrows-v',
            'fa-asl-interpreting'=> 'fa-asl-interpreting',
            'fa-assistive-listening-systems'=> 'fa-assistive-listening-systems',
            'fa-asterisk'=> 'fa-asterisk',
            'fa-at'=> 'fa-at',
            'fa-audio-description'=> 'fa-audio-description',
            'fa-automobile'=> 'fa-automobile',
            'fa-backward'=> 'fa-backward',
            'fa-balance-scale'=> 'fa-balance-scale',
            'fa-ban'=> 'fa-ban',
            'fa-bandcamp'=> 'fa-bandcamp',
            'fa-bank'=> 'fa-bank',
            'fa-bar-chart'=> 'fa-bar-chart',
            'fa-bar-chart-o'=> 'fa-bar-chart-o',
            'fa-barcode'=> 'fa-barcode',
            'fa-bars'=> 'fa-bars',
            'fa-bath'=> 'fa-bath',
            'fa-bathtub'=> 'fa-bathtub',
            'fa-battery'=> 'fa-battery',
            'fa-battery-0'=> 'fa-battery-0',
            'fa-battery-1'=> 'fa-battery-1',
            'fa-battery-2'=> 'fa-battery-2',
            'fa-battery-3'=> 'fa-battery-3',
            'fa-battery-4'=> 'fa-battery-4',
            'fa-battery-empty'=> 'fa-battery-empty',
            'fa-battery-full'=> 'fa-battery-full',
            'fa-battery-half'=> 'fa-battery-half',
            'fa-battery-quarter'=> 'fa-battery-quarter',
            'fa-battery-three-quarters'=> 'fa-battery-three-quarters',
            'fa-bed'=> 'fa-bed',
            'fa-beer'=> 'fa-beer',
            'fa-behance'=> 'fa-behance',
            'fa-behance-square'=> 'fa-behance-square',
            'fa-bell'=> 'fa-bell',
            'fa-bell-o'=> 'fa-bell-o',
            'fa-bell-slash'=> 'fa-bell-slash',
            'fa-bell-slash-o'=> 'fa-bell-slash-o',
            'fa-bicycle'=> 'fa-bicycle',
            'fa-binoculars'=> 'fa-binoculars',
            'fa-birthday-cake'=> 'fa-birthday-cake',
            'fa-bitbucket'=> 'fa-bitbucket',
            'fa-bitbucket-square'=> 'fa-bitbucket-square',
            'fa-bitcoin'=> 'fa-bitcoin',
            'fa-black-tie'=> 'fa-black-tie',
            'fa-blind'=> 'fa-blind',
            'fa-bluetooth'=> 'fa-bluetooth',
            'fa-bluetooth-b'=> 'fa-bluetooth-b',
            'fa-bold'=> 'fa-bold',
            'fa-bolt'=> 'fa-bolt',
            'fa-bomb'=> 'fa-bomb',
            'fa-book'=> 'fa-book',
            'fa-bookmark'=> 'fa-bookmark',
            'fa-bookmark-o'=> 'fa-bookmark-o',
            'fa-braille'=> 'fa-braille',
            'fa-briefcase'=> 'fa-briefcase',
            'fa-btc'=> 'fa-btc',
            'fa-bug'=> 'fa-bug',
            'fa-building'=> 'fa-building',
            'fa-building-o'=> 'fa-building-o',
            'fa-bullhorn'=> 'fa-bullhorn',
            'fa-bullseye'=> 'fa-bullseye',
            'fa-bus'=> 'fa-bus',
            'fa-buysellads'=> 'fa-buysellads',
            'fa-cab'=> 'fa-cab',
            'fa-calculator'=> 'fa-calculator',
            'fa-calendar'=> 'fa-calendar',
            'fa-calendar-check-o'=> 'fa-calendar-check-o',
            'fa-calendar-minus-o'=> 'fa-calendar-minus-o',
            'fa-calendar-o'=> 'fa-calendar-o',
            'fa-calendar-plus-o'=> 'fa-calendar-plus-o',
            'fa-calendar-times-o'=> 'fa-calendar-times-o',
            'fa-camera'=> 'fa-camera',
            'fa-camera-retro'=> 'fa-camera-retro',
            'fa-car'=> 'fa-car',
            'fa-caret-down'=> 'fa-caret-down',
            'fa-caret-left'=> 'fa-caret-left',
            'fa-caret-right'=> 'fa-caret-right',
            'fa-caret-square-o-down'=> 'fa-caret-square-o-down',
            'fa-caret-square-o-left'=> 'fa-caret-square-o-left',
            'fa-caret-square-o-right'=> 'fa-caret-square-o-right',
            'fa-caret-square-o-up'=> 'fa-caret-square-o-up',
            'fa-caret-up'=> 'fa-caret-up',
            'fa-cart-arrow-down'=> 'fa-cart-arrow-down',
            'fa-cart-plus'=> 'fa-cart-plus',
            'fa-cc'=> 'fa-cc',
            'fa-cc-amex'=> 'fa-cc-amex',
            'fa-cc-diners-club'=> 'fa-cc-diners-club',
            'fa-cc-discover'=> 'fa-cc-discover',
            'fa-cc-jcb'=> 'fa-cc-jcb',
            'fa-cc-mastercard'=> 'fa-cc-mastercard',
            'fa-cc-paypal'=> 'fa-cc-paypal',
            'fa-cc-stripe'=> 'fa-cc-stripe',
            'fa-cc-visa'=> 'fa-cc-visa',
            'fa-certificate'=> 'fa-certificate',
            'fa-chain'=> 'fa-chain',
            'fa-chain-broken'=> 'fa-chain-broken',
            'fa-check'=> 'fa-check',
            'fa-check-circle'=> 'fa-check-circle',
            'fa-check-circle-o'=> 'fa-check-circle-o',
            'fa-check-square'=> 'fa-check-square',
            'fa-check-square-o'=> 'fa-check-square-o',
            'fa-chevron-circle-down'=> 'fa-chevron-circle-down',
            'fa-chevron-circle-left'=> 'fa-chevron-circle-left',
            'fa-chevron-circle-right'=> 'fa-chevron-circle-right',
            'fa-chevron-circle-up'=> 'fa-chevron-circle-up',
            'fa-chevron-down'=> 'fa-chevron-down',
            'fa-chevron-left'=> 'fa-chevron-left',
            'fa-chevron-right'=> 'fa-chevron-right',
            'fa-chevron-up'=> 'fa-chevron-up',
            'fa-child'=> 'fa-child',
            'fa-chrome'=> 'fa-chrome',
            'fa-circle'=> 'fa-circle',
            'fa-circle-o'=> 'fa-circle-o',
            'fa-circle-o-notch'=> 'fa-circle-o-notch',
            'fa-circle-thin'=> 'fa-circle-thin',
            'fa-clipboard'=> 'fa-clipboard',
            'fa-clock-o'=> 'fa-clock-o',
            'fa-clone'=> 'fa-clone',
            'fa-close'=> 'fa-close',
            'fa-cloud'=> 'fa-cloud',
            'fa-cloud-download'=> 'fa-cloud-download',
            'fa-cloud-upload'=> 'fa-cloud-upload',
            'fa-cny'=> 'fa-cny',
            'fa-code'=> 'fa-code',
            'fa-code-fork'=> 'fa-code-fork',
            'fa-codepen'=> 'fa-codepen',
            'fa-codiepie'=> 'fa-codiepie',
            'fa-coffee'=> 'fa-coffee',
            'fa-cog'=> 'fa-cog',
            'fa-cogs'=> 'fa-cogs',
            'fa-columns'=> 'fa-columns',
            'fa-comment'=> 'fa-comment',
            'fa-comment-o'=> 'fa-comment-o',
            'fa-commenting'=> 'fa-commenting',
            'fa-commenting-o'=> 'fa-commenting-o',
            'fa-comments'=> 'fa-comments',
            'fa-comments-o'=> 'fa-comments-o',
            'fa-compass'=> 'fa-compass',
            'fa-compress'=> 'fa-compress',
            'fa-connectdevelop'=> 'fa-connectdevelop',
            'fa-contao'=> 'fa-contao',
            'fa-copy'=> 'fa-copy',
            'fa-copyright'=> 'fa-copyright',
            'fa-creative-commons'=> 'fa-creative-commons',
            'fa-credit-card'=> 'fa-credit-card',
            'fa-credit-card-alt'=> 'fa-credit-card-alt',
            'fa-crop'=> 'fa-crop',
            'fa-crosshairs'=> 'fa-crosshairs',
            'fa-css3'=> 'fa-css3',
            'fa-cube'=> 'fa-cube',
            'fa-cubes'=> 'fa-cubes',
            'fa-cut'=> 'fa-cut',
            'fa-cutlery'=> 'fa-cutlery',
            'fa-dashboard'=> 'fa-dashboard',
            'fa-dashcube'=> 'fa-dashcube',
            'fa-database'=> 'fa-database',
            'fa-deaf'=> 'fa-deaf',
            'fa-deafness'=> 'fa-deafness',
            'fa-dedent'=> 'fa-dedent',
            'fa-delicious'=> 'fa-delicious',
            'fa-desktop'=> 'fa-desktop',
            'fa-deviantart'=> 'fa-deviantart',
            'fa-diamond'=> 'fa-diamond',
            'fa-digg'=> 'fa-digg',
            'fa-dollar'=> 'fa-dollar',
            'fa-dot-circle-o'=> 'fa-dot-circle-o',
            'fa-download'=> 'fa-download',
            'fa-dribbble'=> 'fa-dribbble',
            'fa-drivers-license'=> 'fa-drivers-license',
            'fa-drivers-license-o'=> 'fa-drivers-license-o',
            'fa-dropbox'=> 'fa-dropbox',
            'fa-drupal'=> 'fa-drupal',
            'fa-edge'=> 'fa-edge',
            'fa-edit'=> 'fa-edit',
            'fa-eercast'=> 'fa-eercast',
            'fa-eject'=> 'fa-eject',
            'fa-ellipsis-h'=> 'fa-ellipsis-h',
            'fa-ellipsis-v'=> 'fa-ellipsis-v',
            'fa-empire'=> 'fa-empire',
            'fa-envelope'=> 'fa-envelope',
            'fa-envelope-o'=> 'fa-envelope-o',
            'fa-envelope-open'=> 'fa-envelope-open',
            'fa-envelope-open-o'=> 'fa-envelope-open-o',
            'fa-envelope-square'=> 'fa-envelope-square',
            'fa-envira'=> 'fa-envira',
            'fa-eraser'=> 'fa-eraser',
            'fa-etsy'=> 'fa-etsy',
            'fa-eur'=> 'fa-eur',
            'fa-euro'=> 'fa-euro',
            'fa-exchange'=> 'fa-exchange',
            'fa-exclamation'=> 'fa-exclamation',
            'fa-exclamation-circle'=> 'fa-exclamation-circle',
            'fa-exclamation-triangle'=> 'fa-exclamation-triangle',
            'fa-expand'=> 'fa-expand',
            'fa-expeditedssl'=> 'fa-expeditedssl',
            'fa-external-link'=> 'fa-external-link',
            'fa-external-link-square'=> 'fa-external-link-square',
            'fa-eye'=> 'fa-eye',
            'fa-eye-slash'=> 'fa-eye-slash',
            'fa-eyedropper'=> 'fa-eyedropper',
            'fa-fa'=> 'fa-fa',
            'fa-facebook'=> 'fa-facebook',
            'fa-facebook-f'=> 'fa-facebook-f',
            'fa-facebook-official'=> 'fa-facebook-official',
            'fa-facebook-square'=> 'fa-facebook-square',
            'fa-fast-backward'=> 'fa-fast-backward',
            'fa-fast-forward'=> 'fa-fast-forward',
            'fa-fax'=> 'fa-fax',
            'fa-feed'=> 'fa-feed',
            'fa-female'=> 'fa-female',
            'fa-fighter-jet'=> 'fa-fighter-jet',
            'fa-file'=> 'fa-file',
            'fa-file-archive-o'=> 'fa-file-archive-o',
            'fa-file-audio-o'=> 'fa-file-audio-o',
            'fa-file-code-o'=> 'fa-file-code-o',
            'fa-file-excel-o'=> 'fa-file-excel-o',
            'fa-file-image-o'=> 'fa-file-image-o',
            'fa-file-movie-o'=> 'fa-file-movie-o',
            'fa-file-o'=> 'fa-file-o',
            'fa-file-pdf-o'=> 'fa-file-pdf-o',
            'fa-file-photo-o'=> 'fa-file-photo-o',
            'fa-file-picture-o'=> 'fa-file-picture-o',
            'fa-file-powerpoint-o'=> 'fa-file-powerpoint-o',
            'fa-file-sound-o'=> 'fa-file-sound-o',
            'fa-file-text'=> 'fa-file-text',
            'fa-file-text-o'=> 'fa-file-text-o',
            'fa-file-video-o'=> 'fa-file-video-o',
            'fa-file-word-o'=> 'fa-file-word-o',
            'fa-file-zip-o'=> 'fa-file-zip-o',
            'fa-files-o'=> 'fa-files-o',
            'fa-film'=> 'fa-film',
            'fa-filter'=> 'fa-filter',
            'fa-fire'=> 'fa-fire',
            'fa-fire-extinguisher'=> 'fa-fire-extinguisher',
            'fa-firefox'=> 'fa-firefox',
            'fa-first-order'=> 'fa-first-order',
            'fa-flag'=> 'fa-flag',
            'fa-flag-checkered'=> 'fa-flag-checkered',
            'fa-flag-o'=> 'fa-flag-o',
            'fa-flash'=> 'fa-flash',
            'fa-flask'=> 'fa-flask',
            'fa-flickr'=> 'fa-flickr',
            'fa-floppy-o'=> 'fa-floppy-o',
            'fa-folder'=> 'fa-folder',
            'fa-folder-o'=> 'fa-folder-o',
            'fa-folder-open'=> 'fa-folder-open',
            'fa-folder-open-o'=> 'fa-folder-open-o',
            'fa-font'=> 'fa-font',
            'fa-font-awesome'=> 'fa-font-awesome',
            'fa-fonticons'=> 'fa-fonticons',
            'fa-fort-awesome'=> 'fa-fort-awesome',
            'fa-forumbee'=> 'fa-forumbee',
            'fa-forward'=> 'fa-forward',
            'fa-foursquare'=> 'fa-foursquare',
            'fa-free-code-camp'=> 'fa-free-code-camp',
            'fa-frown-o'=> 'fa-frown-o',
            'fa-futbol-o'=> 'fa-futbol-o',
            'fa-gamepad'=> 'fa-gamepad',
            'fa-gavel'=> 'fa-gavel',
            'fa-gbp'=> 'fa-gbp',
            'fa-ge'=> 'fa-ge',
            'fa-gear'=> 'fa-gear',
            'fa-gears'=> 'fa-gears',
            'fa-genderless'=> 'fa-genderless',
            'fa-get-pocket'=> 'fa-get-pocket',
            'fa-gg'=> 'fa-gg',
            'fa-gg-circle'=> 'fa-gg-circle',
            'fa-gift'=> 'fa-gift',
            'fa-git'=> 'fa-git',
            'fa-git-square'=> 'fa-git-square',
            'fa-github'=> 'fa-github',
            'fa-github-alt'=> 'fa-github-alt',
            'fa-github-square'=> 'fa-github-square',
            'fa-gitlab'=> 'fa-gitlab',
            'fa-gittip'=> 'fa-gittip',
            'fa-glass'=> 'fa-glass',
            'fa-glide'=> 'fa-glide',
            'fa-glide-g'=> 'fa-glide-g',
            'fa-globe'=> 'fa-globe',
            'fa-google'=> 'fa-google',
            'fa-google-plus'=> 'fa-google-plus',
            'fa-google-plus-circle'=> 'fa-google-plus-circle',
            'fa-google-plus-official'=> 'fa-google-plus-official',
            'fa-google-plus-square'=> 'fa-google-plus-square',
            'fa-google-wallet'=> 'fa-google-wallet',
            'fa-graduation-cap'=> 'fa-graduation-cap',
            'fa-gratipay'=> 'fa-gratipay',
            'fa-grav'=> 'fa-grav',
            'fa-group'=> 'fa-group',
            'fa-h-square'=> 'fa-h-square',
            'fa-hacker-news'=> 'fa-hacker-news',
            'fa-hand-grab-o'=> 'fa-hand-grab-o',
            'fa-hand-lizard-o'=> 'fa-hand-lizard-o',
            'fa-hand-o-down'=> 'fa-hand-o-down',
            'fa-hand-o-left'=> 'fa-hand-o-left',
            'fa-hand-o-right'=> 'fa-hand-o-right',
            'fa-hand-o-up'=> 'fa-hand-o-up',
            'fa-hand-paper-o'=> 'fa-hand-paper-o',
            'fa-hand-peace-o'=> 'fa-hand-peace-o',
            'fa-hand-pointer-o'=> 'fa-hand-pointer-o',
            'fa-hand-rock-o'=> 'fa-hand-rock-o',
            'fa-hand-scissors-o'=> 'fa-hand-scissors-o',
            'fa-hand-spock-o'=> 'fa-hand-spock-o',
            'fa-hand-stop-o'=> 'fa-hand-stop-o',
            'fa-handshake-o'=> 'fa-handshake-o',
            'fa-hard-of-hearing'=> 'fa-hard-of-hearing',
            'fa-hashtag'=> 'fa-hashtag',
            'fa-hdd-o'=> 'fa-hdd-o',
            'fa-header'=> 'fa-header',
            'fa-headphones'=> 'fa-headphones',
            'fa-heart'=> 'fa-heart',
            'fa-heart-o'=> 'fa-heart-o',
            'fa-heartbeat'=> 'fa-heartbeat',
            'fa-history'=> 'fa-history',
            'fa-home'=> 'fa-home',
            'fa-hospital-o'=> 'fa-hospital-o',
            'fa-hotel'=> 'fa-hotel',
            'fa-hourglass'=> 'fa-hourglass',
            'fa-hourglass-1'=> 'fa-hourglass-1',
            'fa-hourglass-2'=> 'fa-hourglass-2',
            'fa-hourglass-3'=> 'fa-hourglass-3',
            'fa-hourglass-end'=> 'fa-hourglass-end',
            'fa-hourglass-half'=> 'fa-hourglass-half',
            'fa-hourglass-o'=> 'fa-hourglass-o',
            'fa-hourglass-start'=> 'fa-hourglass-start',
            'fa-houzz'=> 'fa-houzz',
            'fa-html5'=> 'fa-html5',
            'fa-i-cursor'=> 'fa-i-cursor',
            'fa-id-badge'=> 'fa-id-badge',
            'fa-id-card'=> 'fa-id-card',
            'fa-id-card-o'=> 'fa-id-card-o',
            'fa-ils'=> 'fa-ils',
            'fa-image'=> 'fa-image',
            'fa-imdb'=> 'fa-imdb',
            'fa-inbox'=> 'fa-inbox',
            'fa-indent'=> 'fa-indent',
            'fa-industry'=> 'fa-industry',
            'fa-info'=> 'fa-info',
            'fa-info-circle'=> 'fa-info-circle',
            'fa-inr'=> 'fa-inr',
            'fa-instagram'=> 'fa-instagram',
            'fa-institution'=> 'fa-institution',
            'fa-internet-explorer'=> 'fa-internet-explorer',
            'fa-intersex'=> 'fa-intersex',
            'fa-ioxhost'=> 'fa-ioxhost',
            'fa-italic'=> 'fa-italic',
            'fa-joomla'=> 'fa-joomla',
            'fa-jpy'=> 'fa-jpy',
            'fa-jsfiddle'=> 'fa-jsfiddle',
            'fa-key'=> 'fa-key',
            'fa-keyboard-o'=> 'fa-keyboard-o',
            'fa-krw'=> 'fa-krw',
            'fa-language'=> 'fa-language',
            'fa-laptop'=> 'fa-laptop',
            'fa-lastfm'=> 'fa-lastfm',
            'fa-lastfm-square'=> 'fa-lastfm-square',
            'fa-leaf'=> 'fa-leaf',
            'fa-leanpub'=> 'fa-leanpub',
            'fa-legal'=> 'fa-legal',
            'fa-lemon-o'=> 'fa-lemon-o',
            'fa-level-down'=> 'fa-level-down',
            'fa-level-up'=> 'fa-level-up',
            'fa-life-bouy'=> 'fa-life-bouy',
            'fa-life-buoy'=> 'fa-life-buoy',
            'fa-life-ring'=> 'fa-life-ring',
            'fa-life-saver'=> 'fa-life-saver',
            'fa-lightbulb-o'=> 'fa-lightbulb-o',
            'fa-line-chart'=> 'fa-line-chart',
            'fa-link'=> 'fa-link',
            'fa-linkedin'=> 'fa-linkedin',
            'fa-linkedin-square'=> 'fa-linkedin-square',
            'fa-linode'=> 'fa-linode',
            'fa-linux'=> 'fa-linux',
            'fa-list'=> 'fa-list',
            'fa-list-alt'=> 'fa-list-alt',
            'fa-list-ol'=> 'fa-list-ol',
            'fa-list-ul'=> 'fa-list-ul',
            'fa-location-arrow'=> 'fa-location-arrow',
            'fa-lock'=> 'fa-lock',
            'fa-long-arrow-down'=> 'fa-long-arrow-down',
            'fa-long-arrow-left'=> 'fa-long-arrow-left',
            'fa-long-arrow-right'=> 'fa-long-arrow-right',
            'fa-long-arrow-up'=> 'fa-long-arrow-up',
            'fa-low-vision'=> 'fa-low-vision',
            'fa-magic'=> 'fa-magic',
            'fa-magnet'=> 'fa-magnet',
            'fa-mail-forward'=> 'fa-mail-forward',
            'fa-mail-reply'=> 'fa-mail-reply',
            'fa-mail-reply-all'=> 'fa-mail-reply-all',
            'fa-male'=> 'fa-male',
            'fa-map'=> 'fa-map',
            'fa-map-marker'=> 'fa-map-marker',
            'fa-map-o'=> 'fa-map-o',
            'fa-map-pin'=> 'fa-map-pin',
            'fa-map-signs'=> 'fa-map-signs',
            'fa-mars'=> 'fa-mars',
            'fa-mars-double'=> 'fa-mars-double',
            'fa-mars-stroke'=> 'fa-mars-stroke',
            'fa-mars-stroke-h'=> 'fa-mars-stroke-h',
            'fa-mars-stroke-v'=> 'fa-mars-stroke-v',
            'fa-maxcdn'=> 'fa-maxcdn',
            'fa-meanpath'=> 'fa-meanpath',
            'fa-medium'=> 'fa-medium',
            'fa-medkit'=> 'fa-medkit',
            'fa-meetup'=> 'fa-meetup',
            'fa-meh-o'=> 'fa-meh-o',
            'fa-mercury'=> 'fa-mercury',
            'fa-microchip'=> 'fa-microchip',
            'fa-microphone'=> 'fa-microphone',
            'fa-microphone-slash'=> 'fa-microphone-slash',
            'fa-minus'=> 'fa-minus',
            'fa-minus-circle'=> 'fa-minus-circle',
            'fa-minus-square'=> 'fa-minus-square',
            'fa-minus-square-o'=> 'fa-minus-square-o',
            'fa-mixcloud'=> 'fa-mixcloud',
            'fa-mobile'=> 'fa-mobile',
            'fa-mobile-phone'=> 'fa-mobile-phone',
            'fa-modx'=> 'fa-modx',
            'fa-money'=> 'fa-money',
            'fa-moon-o'=> 'fa-moon-o',
            'fa-mortar-board'=> 'fa-mortar-board',
            'fa-motorcycle'=> 'fa-motorcycle',
            'fa-mouse-pointer'=> 'fa-mouse-pointer',
            'fa-music'=> 'fa-music',
            'fa-navicon'=> 'fa-navicon',
            'fa-neuter'=> 'fa-neuter',
            'fa-newspaper-o'=> 'fa-newspaper-o',
            'fa-object-group'=> 'fa-object-group',
            'fa-object-ungroup'=> 'fa-object-ungroup',
            'fa-odnoklassniki'=> 'fa-odnoklassniki',
            'fa-odnoklassniki-square'=> 'fa-odnoklassniki-square',
            'fa-opencart'=> 'fa-opencart',
            'fa-openid'=> 'fa-openid',
            'fa-opera'=> 'fa-opera',
            'fa-optin-monster'=> 'fa-optin-monster',
            'fa-outdent'=> 'fa-outdent',
            'fa-pagelines'=> 'fa-pagelines',
            'fa-paint-brush'=> 'fa-paint-brush',
            'fa-paper-plane'=> 'fa-paper-plane',
            'fa-paper-plane-o'=> 'fa-paper-plane-o',
            'fa-paperclip'=> 'fa-paperclip',
            'fa-paragraph'=> 'fa-paragraph',
            'fa-paste'=> 'fa-paste',
            'fa-pause'=> 'fa-pause',
            'fa-pause-circle'=> 'fa-pause-circle',
            'fa-pause-circle-o'=> 'fa-pause-circle-o',
            'fa-paw'=> 'fa-paw',
            'fa-paypal'=> 'fa-paypal',
            'fa-pencil'=> 'fa-pencil',
            'fa-pencil-square'=> 'fa-pencil-square',
            'fa-pencil-square-o'=> 'fa-pencil-square-o',
            'fa-percent'=> 'fa-percent',
            'fa-phone'=> 'fa-phone',
            'fa-phone-square'=> 'fa-phone-square',
            'fa-photo'=> 'fa-photo',
            'fa-picture-o'=> 'fa-picture-o',
            'fa-pie-chart'=> 'fa-pie-chart',
            'fa-pied-piper'=> 'fa-pied-piper',
            'fa-pied-piper-alt'=> 'fa-pied-piper-alt',
            'fa-pied-piper-pp'=> 'fa-pied-piper-pp',
            'fa-pinterest'=> 'fa-pinterest',
            'fa-pinterest-p'=> 'fa-pinterest-p',
            'fa-pinterest-square'=> 'fa-pinterest-square',
            'fa-plane'=> 'fa-plane',
            'fa-play'=> 'fa-play',
            'fa-play-circle'=> 'fa-play-circle',
            'fa-play-circle-o'=> 'fa-play-circle-o',
            'fa-plug'=> 'fa-plug',
            'fa-plus'=> 'fa-plus',
            'fa-plus-circle'=> 'fa-plus-circle',
            'fa-plus-square'=> 'fa-plus-square',
            'fa-plus-square-o'=> 'fa-plus-square-o',
            'fa-podcast'=> 'fa-podcast',
            'fa-power-off'=> 'fa-power-off',
            'fa-print'=> 'fa-print',
            'fa-product-hunt'=> 'fa-product-hunt',
            'fa-puzzle-piece'=> 'fa-puzzle-piece',
            'fa-qq'=> 'fa-qq',
            'fa-qrcode'=> 'fa-qrcode',
            'fa-question'=> 'fa-question',
            'fa-question-circle'=> 'fa-question-circle',
            'fa-question-circle-o'=> 'fa-question-circle-o',
            'fa-quora'=> 'fa-quora',
            'fa-quote-left'=> 'fa-quote-left',
            'fa-quote-right'=> 'fa-quote-right',
            'fa-ra'=> 'fa-ra',
            'fa-random'=> 'fa-random',
            'fa-ravelry'=> 'fa-ravelry',
            'fa-rebel'=> 'fa-rebel',
            'fa-recycle'=> 'fa-recycle',
            'fa-reddit'=> 'fa-reddit',
            'fa-reddit-alien'=> 'fa-reddit-alien',
            'fa-reddit-square'=> 'fa-reddit-square',
            'fa-refresh'=> 'fa-refresh',
            'fa-registered'=> 'fa-registered',
            'fa-remove'=> 'fa-remove',
            'fa-renren'=> 'fa-renren',
            'fa-reorder'=> 'fa-reorder',
            'fa-repeat'=> 'fa-repeat',
            'fa-reply'=> 'fa-reply',
            'fa-reply-all'=> 'fa-reply-all',
            'fa-resistance'=> 'fa-resistance',
            'fa-retweet'=> 'fa-retweet',
            'fa-rmb'=> 'fa-rmb',
            'fa-road'=> 'fa-road',
            'fa-rocket'=> 'fa-rocket',
            'fa-rotate-left'=> 'fa-rotate-left',
            'fa-rotate-right'=> 'fa-rotate-right',
            'fa-rouble'=> 'fa-rouble',
            'fa-rss'=> 'fa-rss',
            'fa-rss-square'=> 'fa-rss-square',
            'fa-rub'=> 'fa-rub',
            'fa-ruble'=> 'fa-ruble',
            'fa-rupee'=> 'fa-rupee',
            'fa-s15'=> 'fa-s15',
            'fa-safari'=> 'fa-safari',
            'fa-save'=> 'fa-save',
            'fa-scissors'=> 'fa-scissors',
            'fa-scribd'=> 'fa-scribd',
            'fa-search'=> 'fa-search',
            'fa-search-minus'=> 'fa-search-minus',
            'fa-search-plus'=> 'fa-search-plus',
            'fa-sellsy'=> 'fa-sellsy',
            'fa-send'=> 'fa-send',
            'fa-send-o'=> 'fa-send-o',
            'fa-server'=> 'fa-server',
            'fa-share'=> 'fa-share',
            'fa-share-alt'=> 'fa-share-alt',
            'fa-share-alt-square'=> 'fa-share-alt-square',
            'fa-share-square'=> 'fa-share-square',
            'fa-share-square-o'=> 'fa-share-square-o',
            'fa-shekel'=> 'fa-shekel',
            'fa-sheqel'=> 'fa-sheqel',
            'fa-shield'=> 'fa-shield',
            'fa-ship'=> 'fa-ship',
            'fa-shirtsinbulk'=> 'fa-shirtsinbulk',
            'fa-shopping-bag'=> 'fa-shopping-bag',
            'fa-shopping-basket'=> 'fa-shopping-basket',
            'fa-shopping-cart'=> 'fa-shopping-cart',
            'fa-shower'=> 'fa-shower',
            'fa-sign-in'=> 'fa-sign-in',
            'fa-sign-language'=> 'fa-sign-language',
            'fa-sign-out'=> 'fa-sign-out',
            'fa-signal'=> 'fa-signal',
            'fa-signing'=> 'fa-signing',
            'fa-simplybuilt'=> 'fa-simplybuilt',
            'fa-sitemap'=> 'fa-sitemap',
            'fa-skyatlas'=> 'fa-skyatlas',
            'fa-skype'=> 'fa-skype',
            'fa-slack'=> 'fa-slack',
            'fa-sliders'=> 'fa-sliders',
            'fa-slideshare'=> 'fa-slideshare',
            'fa-smile-o'=> 'fa-smile-o',
            'fa-snapchat'=> 'fa-snapchat',
            'fa-snapchat-ghost'=> 'fa-snapchat-ghost',
            'fa-snapchat-square'=> 'fa-snapchat-square',
            'fa-snowflake-o'=> 'fa-snowflake-o',
            'fa-soccer-ball-o'=> 'fa-soccer-ball-o',
            'fa-sort'=> 'fa-sort',
            'fa-sort-alpha-asc'=> 'fa-sort-alpha-asc',
            'fa-sort-alpha-desc'=> 'fa-sort-alpha-desc',
            'fa-sort-amount-asc'=> 'fa-sort-amount-asc',
            'fa-sort-amount-desc'=> 'fa-sort-amount-desc',
            'fa-sort-asc'=> 'fa-sort-asc',
            'fa-sort-desc'=> 'fa-sort-desc',
            'fa-sort-down'=> 'fa-sort-down',
            'fa-sort-numeric-asc'=> 'fa-sort-numeric-asc',
            'fa-sort-numeric-desc'=> 'fa-sort-numeric-desc',
            'fa-sort-up'=> 'fa-sort-up',
            'fa-soundcloud'=> 'fa-soundcloud',
            'fa-space-shuttle'=> 'fa-space-shuttle',
            'fa-spinner'=> 'fa-spinner',
            'fa-spoon'=> 'fa-spoon',
            'fa-spotify'=> 'fa-spotify',
            'fa-square'=> 'fa-square',
            'fa-square-o'=> 'fa-square-o',
            'fa-stack-exchange'=> 'fa-stack-exchange',
            'fa-stack-overflow'=> 'fa-stack-overflow',
            'fa-star'=> 'fa-star',
            'fa-star-half'=> 'fa-star-half',
            'fa-star-half-empty'=> 'fa-star-half-empty',
            'fa-star-half-full'=> 'fa-star-half-full',
            'fa-star-half-o'=> 'fa-star-half-o',
            'fa-star-o'=> 'fa-star-o',
            'fa-steam'=> 'fa-steam',
            'fa-steam-square'=> 'fa-steam-square',
            'fa-step-backward'=> 'fa-step-backward',
            'fa-step-forward'=> 'fa-step-forward',
            'fa-stethoscope'=> 'fa-stethoscope',
            'fa-sticky-note'=> 'fa-sticky-note',
            'fa-sticky-note-o'=> 'fa-sticky-note-o',
            'fa-stop'=> 'fa-stop',
            'fa-stop-circle'=> 'fa-stop-circle',
            'fa-stop-circle-o'=> 'fa-stop-circle-o',
            'fa-street-view'=> 'fa-street-view',
            'fa-strikethrough'=> 'fa-strikethrough',
            'fa-stumbleupon'=> 'fa-stumbleupon',
            'fa-stumbleupon-circle'=> 'fa-stumbleupon-circle',
            'fa-subscript'=> 'fa-subscript',
            'fa-subway'=> 'fa-subway',
            'fa-suitcase'=> 'fa-suitcase',
            'fa-sun-o'=> 'fa-sun-o',
            'fa-superpowers'=> 'fa-superpowers',
            'fa-superscript'=> 'fa-superscript',
            'fa-support'=> 'fa-support',
            'fa-table'=> 'fa-table',
            'fa-tablet'=> 'fa-tablet',
            'fa-tachometer'=> 'fa-tachometer',
            'fa-tag'=> 'fa-tag',
            'fa-tags'=> 'fa-tags',
            'fa-tasks'=> 'fa-tasks',
            'fa-taxi'=> 'fa-taxi',
            'fa-telegram'=> 'fa-telegram',
            'fa-television'=> 'fa-television',
            'fa-tencent-weibo'=> 'fa-tencent-weibo',
            'fa-terminal'=> 'fa-terminal',
            'fa-text-height'=> 'fa-text-height',
            'fa-text-width'=> 'fa-text-width',
            'fa-th'=> 'fa-th',
            'fa-th-large'=> 'fa-th-large',
            'fa-th-list'=> 'fa-th-list',
            'fa-themeisle'=> 'fa-themeisle',
            'fa-thermometer'=> 'fa-thermometer',
            'fa-thermometer-0'=> 'fa-thermometer-0',
            'fa-thermometer-1'=> 'fa-thermometer-1',
            'fa-thermometer-2'=> 'fa-thermometer-2',
            'fa-thermometer-3'=> 'fa-thermometer-3',
            'fa-thermometer-4'=> 'fa-thermometer-4',
            'fa-thermometer-empty'=> 'fa-thermometer-empty',
            'fa-thermometer-full'=> 'fa-thermometer-full',
            'fa-thermometer-half'=> 'fa-thermometer-half',
            'fa-thermometer-quarter'=> 'fa-thermometer-quarter',
            'fa-thermometer-three-quarters'=> 'fa-thermometer-three-quarters',
            'fa-thumb-tack'=> 'fa-thumb-tack',
            'fa-thumbs-down'=> 'fa-thumbs-down',
            'fa-thumbs-o-down'=> 'fa-thumbs-o-down',
            'fa-thumbs-o-up'=> 'fa-thumbs-o-up',
            'fa-thumbs-up'=> 'fa-thumbs-up',
            'fa-ticket'=> 'fa-ticket',
            'fa-times'=> 'fa-times',
            'fa-times-circle'=> 'fa-times-circle',
            'fa-times-circle-o'=> 'fa-times-circle-o',
            'fa-times-rectangle'=> 'fa-times-rectangle',
            'fa-times-rectangle-o'=> 'fa-times-rectangle-o',
            'fa-tint'=> 'fa-tint',
            'fa-toggle-down'=> 'fa-toggle-down',
            'fa-toggle-left'=> 'fa-toggle-left',
            'fa-toggle-off'=> 'fa-toggle-off',
            'fa-toggle-on'=> 'fa-toggle-on',
            'fa-toggle-right'=> 'fa-toggle-right',
            'fa-toggle-up'=> 'fa-toggle-up',
            'fa-trademark'=> 'fa-trademark',
            'fa-train'=> 'fa-train',
            'fa-transgender'=> 'fa-transgender',
            'fa-transgender-alt'=> 'fa-transgender-alt',
            'fa-trash'=> 'fa-trash',
            'fa-trash-o'=> 'fa-trash-o',
            'fa-tree'=> 'fa-tree',
            'fa-trello'=> 'fa-trello',
            'fa-tripadvisor'=> 'fa-tripadvisor',
            'fa-trophy'=> 'fa-trophy',
            'fa-truck'=> 'fa-truck',
            'fa-try'=> 'fa-try',
            'fa-tty'=> 'fa-tty',
            'fa-tumblr'=> 'fa-tumblr',
            'fa-tumblr-square'=> 'fa-tumblr-square',
            'fa-turkish-lira'=> 'fa-turkish-lira',
            'fa-tv'=> 'fa-tv',
            'fa-twitch'=> 'fa-twitch',
            'fa-twitter'=> 'fa-twitter',
            'fa-twitter-square'=> 'fa-twitter-square',
            'fa-umbrella'=> 'fa-umbrella',
            'fa-underline'=> 'fa-underline',
            'fa-undo'=> 'fa-undo',
            'fa-universal-access'=> 'fa-universal-access',
            'fa-university'=> 'fa-university',
            'fa-unlink'=> 'fa-unlink',
            'fa-unlock'=> 'fa-unlock',
            'fa-unlock-alt'=> 'fa-unlock-alt',
            'fa-unsorted'=> 'fa-unsorted',
            'fa-upload'=> 'fa-upload',
            'fa-usb'=> 'fa-usb',
            'fa-usd'=> 'fa-usd',
            'fa-user'=> 'fa-user',
            'fa-user-circle'=> 'fa-user-circle',
            'fa-user-circle-o'=> 'fa-user-circle-o',
            'fa-user-md'=> 'fa-user-md',
            'fa-user-o'=> 'fa-user-o',
            'fa-user-plus'=> 'fa-user-plus',
            'fa-user-secret'=> 'fa-user-secret',
            'fa-user-times'=> 'fa-user-times',
            'fa-users'=> 'fa-users',
            'fa-vcard'=> 'fa-vcard',
            'fa-vcard-o'=> 'fa-vcard-o',
            'fa-venus'=> 'fa-venus',
            'fa-venus-double'=> 'fa-venus-double',
            'fa-venus-mars'=> 'fa-venus-mars',
            'fa-viacoin'=> 'fa-viacoin',
            'fa-viadeo'=> 'fa-viadeo',
            'fa-viadeo-square'=> 'fa-viadeo-square',
            'fa-video-camera'=> 'fa-video-camera',
            'fa-vimeo'=> 'fa-vimeo',
            'fa-vimeo-square'=> 'fa-vimeo-square',
            'fa-vine'=> 'fa-vine',
            'fa-vk'=> 'fa-vk',
            'fa-volume-control-phone'=> 'fa-volume-control-phone',
            'fa-volume-down'=> 'fa-volume-down',
            'fa-volume-off'=> 'fa-volume-off',
            'fa-volume-up'=> 'fa-volume-up',
            'fa-warning'=> 'fa-warning',
            'fa-wechat'=> 'fa-wechat',
            'fa-weibo'=> 'fa-weibo',
            'fa-weixin'=> 'fa-weixin',
            'fa-whatsapp'=> 'fa-whatsapp',
            'fa-wheelchair'=> 'fa-wheelchair',
            'fa-wheelchair-alt'=> 'fa-wheelchair-alt',
            'fa-wifi'=> 'fa-wifi',
            'fa-wikipedia-w'=> 'fa-wikipedia-w',
            'fa-window-close'=> 'fa-window-close',
            'fa-window-close-o'=> 'fa-window-close-o',
            'fa-window-maximize'=> 'fa-window-maximize',
            'fa-window-minimize'=> 'fa-window-minimize',
            'fa-window-restore'=> 'fa-window-restore',
            'fa-windows'=> 'fa-windows',
            'fa-won'=> 'fa-won',
            'fa-wordpress'=> 'fa-wordpress',
            'fa-wpbeginner'=> 'fa-wpbeginner',
            'fa-wpexplorer'=> 'fa-wpexplorer',
            'fa-wpforms'=> 'fa-wpforms',
            'fa-wrench'=> 'fa-wrench',
            'fa-xing'=> 'fa-xing',
            'fa-xing-square'=> 'fa-xing-square',
            'fa-y-combinator'=> 'fa-y-combinator',
            'fa-y-combinator-square'=> 'fa-y-combinator-square',
            'fa-yahoo'=> 'fa-yahoo',
            'fa-yc'=> 'fa-yc',
            'fa-yc-square'=> 'fa-yc-square',
            'fa-yelp'=> 'fa-yelp',
            'fa-yen'=> 'fa-yen',
            'fa-yoast'=> 'fa-yoast',
            'fa-youtube'=> 'fa-youtube',
            'fa-youtube-play'=> 'fa-youtube-play',
            'fa-youtube-square'=> 'fa-youtube-square'
        ];
    }
}
?>