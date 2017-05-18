Ext.define('Infoblock.view.InfoblockUpdateContentCKEditor',
	{
    extend: 'Admin.view.ux.CKEditor',
	alias: 'widget.Infoblock.view.InfoblockUpdateContentCKEditor',
	
	bodyClass: "CONTENT",
	contentsCss: Admin.getApplication().Access.getSetting("appCss")
	}
);