Ext.define('Alias.view.AliasCreateContentCKEditor', 
	{
    extend: 'Admin.view.ux.CKEditor',
	alias: 'widget.Alias.view.AliasCreateContentCKEditor',
	
	bodyClass: "CONTENT",
	contentsCss: Admin.getApplication().Access.getSetting("pathToCssGeneral")
	}
);