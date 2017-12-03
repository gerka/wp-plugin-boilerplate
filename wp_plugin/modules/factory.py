
class factory:
	modules = [
		'admin',
		'admin_page',
		'ajax',
		'autoupdate',
		'compat',
		'gulp',
		'git',
		'model',
		'posttype',
		'settings',
		'shortcode',
		'taxonomy',
		'widget',
	]

	def get( mod ):
		if mod not in factory.modules:
			return False
		module = __import__('wp_plugin.modules.'+mod, fromlist=[mod])
		mod_class = getattr(module,mod)
		return mod_class()