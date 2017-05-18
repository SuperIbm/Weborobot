Ext.define('User.store.PageSelect',
	{
	extend: 'Page.store.Page',
	model: 'Page.model.Page',
	
		requires:
		[
		'Page.model.Page',
		'Page.store.Page'
		],
	
	autoLoad: false
	}
);