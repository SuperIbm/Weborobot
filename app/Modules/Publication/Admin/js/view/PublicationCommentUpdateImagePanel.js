Ext.define('Publication.view.PublicationCommentUpdateImagePanel',
	{
    extend: 'Admin.view.ux.ImagePanel',
	alias: 'widget.Publication.view.PublicationCommentUpdateImagePanel',
	
	uses: ['Publication.store.PublicationCommentImage'],
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
			
		this.store = Ext.create("Publication.store.PublicationCommentImage");
		this.callParent();
		}
	}
);