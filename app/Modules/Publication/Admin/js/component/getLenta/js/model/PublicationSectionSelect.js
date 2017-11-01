Ext.define('Publication.component.getLenta.model.PublicationSectionSelect',
	{
    extend: 'Ext.data.Model',
	name: 'PublicationSectionSelect',
	
	idProperty: 'idPublicationSection',
	clientIdProperty: "idPublicationSection",
	
    	fields:
		[			
			{
			name: "idPublicationSection",
			type: "int"
			},
			{
			name: "labelSection",
			type: "string"
			},
			{
			name: "status",
			type: "string"
			}
		],
		proxy:
		{
		type: 'ajax',
			api:
			{
			read: '_api/Publication/PublicationSectionAdminController/tree/'
			},
			reader:
			{
			type: 'json',
			rootProperty: "data",
			messageProperty: "errortype"
			}
		}
	}
);