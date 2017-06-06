Ext.define('Publication.view.PublicationUpdateImagePanel', 
	{
    extend: 'Admin.view.ux.ImagePanel',
	alias: 'widget.Publication.view.PublicationUpdateImagePanel',
	
	uses: ['Publication.store.PublicationImage'],
	name: "Publication",
	border: true,
	
		initComponent: function()
		{
			this.buttonCreate = 
			{
			text: "Закачать",
			hidden: !Admin.getApplication().Access.is("Publication", "isCreate")
			};
			
			this.buttonDestroy = 
			{
			text: "Удалить",
			hidden: !Admin.getApplication().Access.is("Publication", "isDestroy")
			};
			
		this.store = Ext.create("Publication.store.PublicationImage");
		this.callParent();
		}
	}
);