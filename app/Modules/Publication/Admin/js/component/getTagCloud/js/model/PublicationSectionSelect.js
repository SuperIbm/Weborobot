Ext.define('Publication.component.getTagCloud.model.PublicationSectionSelect',
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
				read: Weborobot.Util.getUrlToModule("Publication", "PublicationSection", "read")
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