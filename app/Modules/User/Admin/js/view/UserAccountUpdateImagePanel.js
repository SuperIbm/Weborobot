Ext.define('User.view.UserAccountUpdateImagePanel', 
	{
	extend: 'Admin.view.ux.ImagePanel',
	alias: 'widget.User.view.UserAccountUpdateImagePanel',
	
	uses: ['User.store.UserAccountImage'],
	name: "User",
	border: true,
	
		initComponent: function()
		{
			this.buttonCreate = 
			{
			text: "Закачать",
			hidden: Admin.getApplication().Access.is("User", "isCreate") == true ? false : true
			};
			
			this.buttonDestroy = 
			{
			text: "Удалить",
			hidden: Admin.getApplication().Access.is("User", "isDestroy") == true ? false : true
			}
			
		this.store = Ext.create("User.store.UserAccountImage");
		this.callParent();
		}
	}
);