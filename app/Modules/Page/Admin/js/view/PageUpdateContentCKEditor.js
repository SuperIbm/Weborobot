Ext.define('Page.view.PageUpdateContentCKEditor', 
	{
    extend: 'Admin.view.ux.CKEditor',
	alias: 'widget.Page.view.PageUpdateContentCKEditor',
	
	bodyClass: "CONTENT",
	contentsCss: Admin.getApplication().Access.getSetting("appCss")
	}
);