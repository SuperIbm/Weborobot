Ext.define('Upload.model.UploadSource',
	{
    extend: 'Ext.data.Model',
	name: 'UploadSource',
	idProperty: 'idUploadSource',
	clientIdProperty: "idUploadSource",
	
    	fields:
		[			
			{
			name: "idUploadSource",
			type: "int"
			},
			{
			name: "login",
			type: "string"
			},
			{
			name: "password",
			type: "string"
			},
			{
			name: "url",
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
		noCache: false,
			api:
			{
            create: '_api/Upload/UploadSourceAdminController/create/',
            update: '_api/Upload/UploadSourceAdminController/update/',
            destroy: '_api/Upload/UploadSourceAdminController/destroy/',
            read: '_api/Upload/UploadSourceAdminController/read/'
			},
			reader:
			{
			type: 'json',
			rootProperty: "data",
			messageProperty: "errortype"
			},
			writer:
			{
			type: 'cgi',
			writeAllFields: true
			}
		}
	}
);