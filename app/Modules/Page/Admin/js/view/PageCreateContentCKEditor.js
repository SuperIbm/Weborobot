Ext.define('Page.view.PageCreateContentCKEditor', 
	{
    extend: 'Admin.view.ux.CKEditor',
	alias: 'widget.Page.view.PageCreateContentCKEditor',
	
	bodyClass: "CONTENT",
	contentsCss: Admin.getApplication().Access.getSetting("appCss")
	}
);