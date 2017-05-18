Ext.define('Infoblock.view.InfoblockCreateContentCKEditor',
	{
    extend: 'Admin.view.ux.CKEditor',
	alias: 'widget.Infoblock.view.InfoblockCreateContentCKEditor',
	
	bodyClass: "CONTENT",
	contentsCss: Admin.getApplication().Access.getSetting("appCss")
	}
);