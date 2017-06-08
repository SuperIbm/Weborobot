Ext.define('Publication.view.PublicationCreateContentCKEditor', 
	{
    extend: 'Admin.view.ux.CKEditor',
	alias: 'widget.Publication.view.PublicationCreateContentCKEditor',
	
	bodyClass: "CONTENT",
	contentsCss: Admin.getApplication().Access.getSetting("appCss")
	}
);