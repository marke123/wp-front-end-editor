<?php

/**
 * This class handles all aloha specific actions like configuration and script dependency management
 */
abstract class FEE_AlohaEditor {

	/**
	 * Enqueues the aloha editor dependencies depending on user status. 
	 * Enqueuing will only performed if the user is loggedin and outsite 
	 * of the admin area (dashboard).
	 */
	static function enqueueAloha() {

		//wp_register_script('aewip',  'js/aewip.js', array (), '0.10', false);
		wp_register_script('aloha.config', plugins_url('js/alohaeditor-config.js.php', FRONT_END_EDITOR_MAIN_FILE), array (), '0.9.3', false);
		wp_register_script('aloha.init', plugins_url('js/alohaeditor-init.js.php', FRONT_END_EDITOR_MAIN_FILE), array (), '0.9.3', false);

		// Deregister jquery and register aloha jquery version
		wp_deregister_script('jquery');
		wp_register_script('jquery', FEE_AlohaEditor::_getAlohaSrcBaseUrl() . 'deps/jquery-1.4.4.js', array (), '0.9.3', false);


		if (is_user_logged_in() && !is_admin()) {
			
			//load jquery
//			wp_enqueue_script('jquery');

			// Initalize aloha
			wp_enqueue_script('aloha.init');
			
			// Load format plugin and all aloha dependencies
			wp_enqueue_script('aloha.format');
			wp_enqueue_script('aloha.highlighteditables');
			//wp_enqueue_script('aloha.ribbon');
			//wp_enqueue_script('aloha.table');
			//wp_enqueue_script('aloha.list');
			
			
			// Load the aloha editor configuration
			wp_enqueue_script('aloha.config');

		}
	}

	/**
	 * Prints the script that enables editables
	 */
	static function printAlohaEditableConfiguration() {
	?>		
	<script type="text/javascript">
	 $(document).ready(function() {
		$('.fee-field').aloha();
			
	 });
	</script> 
	<?

	}

	/**
	 * Returns the absolute baseurl to the aloha editor plugin directory
	 */
	static function _getAlohaPluginsBaseUrl() {
		return FEE_AlohaEditor :: _getAlohaSrcBaseUrl() . 'plugins/';
	}

	/**
	 * Returns the absolute baseurl to the aloha editor src directory
	 */
	static function _getAlohaSrcBaseUrl() {

		$baseUrl = plugins_url('/', 'wp-front-end-editor');
		$baseUrl = $baseUrl . 'wp-front-end-editor/';
		return $baseUrl . 'alohaeditor/WebContent/';
	}

	/**
	 * Registers the aloha editor depdencies and plugins
	 */
	static function registerAloha() {

		$alohaSrcBaseUrl = FEE_AlohaEditor :: _getAlohaSrcBaseUrl();
		$alohaPluginsBaseUrl = FEE_AlohaEditor :: _getAlohaPluginsBaseUrl();

		//Include no deps version for development
		if (defined('SCRIPT_DEBUG')) {

		// Aloha Deps
		wp_register_script('jquery', $alohaSrcBaseUrl . 'deps/jquery-1.4.4.js', array (), '0.9.3', false);
		wp_register_script('jquery.json', $alohaSrcBaseUrl . 'deps/jquery.json-2.2.min.js', array (), '0.9.3', false);
		wp_register_script('jquery.getUrlParam', $alohaSrcBaseUrl . 'deps/jquery.getUrlParam.js', array (), '0.9.3', false);
		wp_register_script('jquery.prettyPhoto', $alohaSrcBaseUrl . 'deps/prettyPhoto/jquery.prettyPhoto.js', array (), '0.9.3', false);
		wp_register_script('jquery.cookie', $alohaSrcBaseUrl . 'deps/jquery.cookie.js', array (), '0.9.3', false);
		wp_register_script('ext-jquery-adapter-debug', $alohaSrcBaseUrl . 'deps/extjs/ext-jquery-adapter-debug.js', array (), '0.9.3', false);
		wp_register_script('ext-foundation-debug', $alohaSrcBaseUrl . 'deps/extjs/ext-foundation-debug.js', array (), '0.9.3', false);
		wp_register_script('cmp-foundation-debug', $alohaSrcBaseUrl . 'deps/extjs/cmp-foundation-debug.js', array (), '0.9.3', false);

		wp_register_script('data-foundation-debug', $alohaSrcBaseUrl . 'deps/extjs/data-foundation-debug.js', array (), '0.9.3', false);
		wp_register_script('data-json-debug', $alohaSrcBaseUrl . 'deps/extjs/data-json-debug.js', array (), '0.9.3', false);
		wp_register_script('data-list-views-debug', $alohaSrcBaseUrl . 'deps/extjs/data-list-views-debug.js', array (), '0.9.3', false);
		wp_register_script('ext-dd.debug', $alohaSrcBaseUrl . 'deps/extjs/ext-dd-debug.js', array (), '0.9.3', false);
		wp_register_script('window-debug', $alohaSrcBaseUrl . 'deps/extjs/window-debug.js', array (), '0.9.3', false);
		wp_register_script('resizable-debug', $alohaSrcBaseUrl . 'deps/extjs/resizable-debug.js', array (), '0.9.3', false);
		wp_register_script('pkg-buttons-debug', $alohaSrcBaseUrl . 'deps/extjs/pkg-buttons-debug.js', array (), '0.9.3', false);
		wp_register_script('pkg-tabs-debug', $alohaSrcBaseUrl . 'deps/extjs/pkg-tabs-debug.js', array (), '0.9.3', false);
		wp_register_script('pkg-tips-debug', $alohaSrcBaseUrl . 'deps/extjs/pkg-tips-debug.js', array (), '0.9.3', false);
		wp_register_script('pkg-tree-debug', $alohaSrcBaseUrl . 'deps/extjs/pkg-tree-debug.js', array (), '0.9.3', false);
		wp_register_script('pkg-grid-foundation-debug', $alohaSrcBaseUrl . 'deps/extjs/pkg-grid-foundation-debug.js', array (), '0.9.3', false);
		wp_register_script('pkg-toolbars-debug', $alohaSrcBaseUrl . 'deps/extjs/pkg-toolbars-debug.js', array (), '0.9.3', false);
		wp_register_script('pkg-menu-debug', $alohaSrcBaseUrl . 'deps/extjs/pkg-menu-debug.js', array (), '0.9.3', false);
		wp_register_script('pkg-forms-debug', $alohaSrcBaseUrl . 'deps/extjs/pkg-forms-debug.js', array (), '0.9.3', false);

		// Aloha JQuery Deps
		wp_register_script('jquery.aloha.ext', $alohaSrcBaseUrl .  'utils/jquery.js', array (), '0.9.3', false);
		
		// Other deps
		wp_register_script('lang', $alohaSrcBaseUrl . 'utils/lang.js', array (), '0.9.3', false);
		wp_register_script('range', $alohaSrcBaseUrl . 'utils/range.js', array (), '0.9.3', false);
		wp_register_script('position', $alohaSrcBaseUrl . 'utils/position.js', array (), '0.9.3', false);
		wp_register_script('dom', $alohaSrcBaseUrl . 'utils/dom.js', array (), '0.9.3', false);
		wp_register_script('indexof', $alohaSrcBaseUrl . 'utils/indexof.js', array (), '0.9.3', false);
		wp_register_script('license', $alohaSrcBaseUrl . 'core/license.js', array (), '0.9.3', false);
		wp_register_script('ext-alohaproxy', $alohaSrcBaseUrl . 'core/ext-alohaproxy.js', array (), '0.9.3', false);
		wp_register_script('ext-alohareader',$alohaSrcBaseUrl . 'core/ext-alohareader.js', array (), '0.9.3', false);
		wp_register_script('ext-alohatreeloader',$alohaSrcBaseUrl.'core/ext-alohatreeloader.js', array (), '0.9.3', false);
		
		
		// register core dependencies
		wp_register_script('core', $alohaSrcBaseUrl . 'core/core.js', array (
			'jquery',
			'jquery.json',
			'jquery.getUrlParam',
			'jquery.prettyPhoto',
			'jquery.cookie',
			'ext-jquery-adapter-debug',			
			'ext-foundation-debug',
			'cmp-foundation-debug',
			'data-foundation-debug',
			'data-json-debug',
			'data-list-views-debug',
			'ext-dd.debug',
			'window-debug',
			'resizable-debug',
			'pkg-buttons-debug',
			'pkg-tabs-debug',
			'pkg-tips-debug',
			'pkg-tree-debug',
			'pkg-grid-foundation-debug',
			'pkg-toolbars-debug',
			'pkg-menu-debug',
			'pkg-forms-debug',
			'jquery.aloha.ext',
			'lang',
			'range',
			'position',
			'dom',
			'indexof',
			'license',
			'ext-alohaproxy',
			'ext-alohareader',
			'ext-alohatreeloader'
		), '0.9.3', false);
	
		

		// register ui scripts
		wp_register_script('ui', $alohaSrcBaseUrl . 'core/ui.js', array (), '0.9.3', false);
		wp_register_script('ui-attributefield', $alohaSrcBaseUrl . 'core/ui-attributefield.js', array (), '0.9.3', false);
		wp_register_script('ui-browser', $alohaSrcBaseUrl . 'core/ui-browser.js', array (), '0.9.3', false);
		wp_register_script('css', $alohaSrcBaseUrl . 'core/css.js', array (), '0.9.3', false);
		wp_register_script('editable', $alohaSrcBaseUrl . 'core/editable.js', array (), '0.9.3', false);
		wp_register_script('ribbon', $alohaSrcBaseUrl . 'core/ribbon.js', array (), '0.9.3', false);
		wp_register_script('event', $alohaSrcBaseUrl . 'core/event.js', array (), '0.9.3', false);
		wp_register_script('floatingmenu', $alohaSrcBaseUrl . 'core/floatingmenu.js', array (), '0.9.3', false);
		wp_register_script('ierange-m2', $alohaSrcBaseUrl . 'core/ierange-m2.js', array (), '0.9.3', false);
		wp_register_script('jquery.aloha', $alohaSrcBaseUrl . 'core/jquery.aloha.js', array (), '0.9.3', false);
		wp_register_script('log', $alohaSrcBaseUrl . 'core/log.js', array (), '0.9.3', false);
		wp_register_script('markup', $alohaSrcBaseUrl . 'core/markup.js', array (), '0.9.3', false);
		wp_register_script('message', $alohaSrcBaseUrl . 'core/message.js', array (), '0.9.3', false);
		wp_register_script('plugin', $alohaSrcBaseUrl . 'core/plugin.js', array (), '0.9.3', false);
		wp_register_script('selection', $alohaSrcBaseUrl . 'core/selection.js', array (), '0.9.3', false);
		wp_register_script('sidebar', $alohaSrcBaseUrl . 'core/sidebar.js', array (), '0.9.3', false);
		wp_register_script('repositorymanager', $alohaSrcBaseUrl . 'core/repositorymanager.js', array (), '0.9.3', false);
		wp_register_script('repository', $alohaSrcBaseUrl . 'core/repository.js', array (), '0.9.3', false);
		wp_register_script('repositoryobjects', $alohaSrcBaseUrl . 'core/repositoryobjects.js', array (), '0.9.3', false);

		$plugindeps = array (
			'core',
			'ui',
			'ui-attributefield',
			'ui-browser',
			'css',
			'editable',
			'ribbon',
			'event',
			'floatingmenu',
			'ierange-m2',
			'jquery.aloha',
			'log',
			'markup',
			'message',
			'plugin',
			'selection',
			'sidebar',
			'repositorymanager',
			'repository',
			'repositoryobjects'
		);

		// Aloha Plugins
		wp_register_script('aloha.format', $alohaPluginsBaseUrl . 'com.gentics.aloha.plugins.Format/plugin.js', $plugindeps, '0.9.3', false);
		wp_register_script('aloha.table', $alohaPluginsBaseUrl . 'com.gentics.aloha.plugins.Table/plugin.js', $plugindeps, '0.9.3', false);
		wp_register_script('aloha.list',  $alohaPluginsBaseUrl . 'com.gentics.aloha.plugins.List/plugin.js', $plugindeps, '0.9.3', false);
		wp_register_script('aloha.link', $alohaPluginsBaseUrl . 'com.gentics.aloha.plugins.Link/plugin.js', $plugindeps, '0.9.3', false);
		wp_register_script('aloha.highlighteditables', $alohaPluginsBaseUrl . 'com.gentics.aloha.plugins.HighlightEditables/plugin.js', $plugindeps, '0.9.3', false);
		wp_register_script('aloha.TOC', $alohaPluginsBaseUrl .'com.gentics.aloha.plugins.TOC/plugin.js' ,$plugindeps, '0.9.3', false);
		wp_register_script('aloha.delicious', $alohaPluginsBaseUrl .'com.gentics.aloha.plugins.Link/delicious.js', $plugindeps, '0.9.3', false);
		wp_register_script('aloha.link', $alohaPluginsBaseUrl .'com.gentics.aloha.plugins.Link/LinkList.js', $plugindeps, '0.9.3', false);
		wp_register_script('aloha.paste', $alohaPluginsBaseUrl . 'com.gentics.aloha.plugins.Paste/plugin.js', $plugindeps, '0.9.3', false);
		wp_register_script('aloha.wordpastehandler', $alohaPluginsBaseUrl .'com.gentics.aloha.plugins.Paste/wordpastehandler.js', $plugindeps, '0.9.3', false);
		
		} else {
			//TODO decide whether we should use the build version
		}
	}

	
	/**
	 * This function will print the aloha editor initialiation javascript
	 */
	static function printAlohaEditorInit() {
	?>
	GENTICS_Aloha_base = '/wp-content/plugins/wp-front-end-editor/alohaeditor/WebContent/';
	<?
	}


	/**
	 * Prints the aloha editor, plugins configuration
	 */
	static function printAlohaEditorConfiguration() {
	?>
	GENTICS.Aloha.settings = {
		logLevels: {'error': true, 'warn': true, 'info': true, 'debug': false},
		errorhandling : false,
		ribbon: false,	
		"i18n": {
			// you can either let the system detect the users language (set acceptLanguage on server)
			// In PHP this would would be '<?=$_SERVER['HTTP_ACCEPT_LANGUAGE']?>' resulting in 
			// "acceptLanguage": 'de-de,de;q=0.8,it;q=0.6,en-us;q=0.7,en;q=0.2'
			// or set current on server side to be in sync with your backend system 
			"current": "en" 
		},
		"repositories": {
		 	"com.gentics.aloha.repositories.LinkList": {
		 		data: [
	 		        { name: 'Aloha Developers Wiki', url:'http://www.aloha-editor.com/wiki', type:'website', weight: 0.50 },
	 		        { name: 'Aloha Editor - The HTML5 Editor', url:'http://aloha-editor.com', type:'website', weight: 0.90  },
	 		        { name: 'Aloha Demo', url:'http://www.aloha-editor.com/demos.html', type:'website', weight: 0.75  },
	 		        { name: 'Aloha Wordpress Demo', url:'http://www.aloha-editor.com/demos/wordpress-demo/index.html', type:'website', weight: 0.75  },
	 		        { name: 'Aloha Logo', url:'http://www.aloha-editor.com/images/aloha-editor-logo.png', type:'image', weight: 0.10  }
		 		]
			}
		},
		"plugins": {
		 	"com.gentics.aloha.plugins.Format": {
			 	// all elements with no specific configuration get this configuration
				config : [ 'b', 'i','sub','sup'],
			  	editables : {
					// no formatting allowed for title
					'#title'	: [ ], 
					// formatting for all editable DIVs
					'div'		: [ 'b', 'i', 'del', 'sub', 'sup'  ], 
					// content is a DIV and has class .article so it gets both buttons
					'.article'	: [ 'b', 'i', 'p', 'title', 'h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'pre', 'removeFormat']
			  	}
			},
		 	"com.gentics.aloha.plugins.List": { 
			 	// all elements with no specific configuration get an UL, just for fun :)
				config : [ 'ul' ],
			  	editables : {
					// Even if this is configured it is not set because OL and UL are not allowed in H1.
					'#title'	: [ 'ol' ], 
					// all divs get OL
					'div'		: [ 'ol' ], 
					// content is a DIV. It would get only OL but with class .article it also gets UL.
					'.article'	: [ 'ul' ]
			  	}
			},
		 	"com.gentics.aloha.plugins.Link": {
			 	// all elements with no specific configuration may insert links
				config : [ 'a' ],
			  	editables : {
					// No links in the title.
					'#title'	: [  ]
			  	},
			  	// all links that match the targetregex will get set the target
	 			// e.g. ^(?!.*aloha-editor.com).* matches all href except aloha-editor.com
			  	targetregex : '^(?!.*aloha-editor.com).*',
			  	// this target is set when either targetregex matches or not set
			    // e.g. _blank opens all links in new window
			  	target : '_blank',
			  	// the same for css class as for target
			  	cssclassregex : '^(?!.*aloha-editor.com).*',
			  	cssclass : 'aloha',
			  	// use all resources of type website for autosuggest
			  	objectTypeFilter: ['website'],
			  	// handle change of href
			  	onHrefChange: function( obj, href, item ) {
				  	if ( item ) {
						jQuery(obj).attr('data-name', item.name);
				  	} else {
						jQuery(obj).removeAttr('data-name');
				  	}
			  	}
			},
		 	"com.gentics.aloha.plugins.Table": { 
			 	// all elements with no specific configuration are not allowed to insert tables
				config : [ ],
			  	editables : {
					// Allow insert tables only into .article
					'.article'	: [ 'table' ] 
			  	}
			}
	  	}
	};		
	<?
	}
}