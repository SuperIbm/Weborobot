Ext.define('User.model.UserAccount',
	{
    extend: 'Ext.data.Model',
	name: 'UserAccount',
	idProperty: 'idUser',
	clientIdProperty: "idUser",
	
    	fields:
		[			
			{
			name: "idUser",
			type: "int"
			},
			
			{
			name: "idImageSmall",
			type: "image"
			},
			{
			name: "idImageMiddle",
			type: "image"
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
			name: "firstname",
			type: "string"
			},
			{
			name: "secondname",
			type: "string"
			},
			{
			name: "lastname",
			type: "string"
			},
			{
			name: "email",
			type: "string"
			},
			{
			name: "telephone",
			type: "string"
			},
			{
			name: "sex",
			type: "string"
			},
			{
			name: "birthday",
			type: "date",
			dateFormat: "Y-m-d H:i:s"
			},
			{
			name: "icq",
			type: "string"
			},
			{
			name: "skype",
			type: "string"
			},
			
			{
			name: "zip",
			type: "string"
			},
			{
			name: "country",
			type: "string"
			},
			{
			name: "city",
			type: "string"
			},
			{
			name: "street",
			type: "string"
			},
			
			{
			name: "organForma",
			type: "string"
			},
			{
			name: "organName",
			type: "string"
			},
			{
			name: "site",
			type: "string"
			},
			
			{
			name: "passportSeriaAndNumber",
			type: "string"
			},
			{
			name: "passportWhoMade",
			type: "string"
			},
			{
			name: "passportWhenMade",
			type: "date",
			dateFormat: "Y-m-d H:i:s"
			},
			{
			name: "passportCodeSection",
			type: "string"
			},
			{
			name: "passportAdress",
			type: "string"
			},

			{
			name: "typeUser",
			type: "string"
			},
			
			{
			name: "dateAdd",
			type: "date",
			dateFormat: "Y-m-d H:i:s"
			},
			{
			name: "dateLastEnter",
			type: "date",
			dateFormat: "Y-m-d H:i:s"
			},
			{
			name: "ip",
			type: "string"
			},
			
			{
			name: "groups"
			},
			
			{
			name: "status",
			type: "string"
			},

			{
			name: "fullLabel",
			type: "string",
				convert: function(value, reg)
				{
				var text = reg.get("login");

					if(reg.get("firstname") || reg.get("secondname"))
					{
					text += " (";

						if(reg.get("firstname")) text += reg.get("firstname");
						if(reg.get("secondname"))
						{
						if(reg.get("firstname")) text += " ";
						text += reg.get("secondname");
						}

					text += ")";
					}

				return text;
				}
			}
		],
		proxy:
		{
		type: 'ajax',
		noCache: false,
			api:
			{
			create: '_api/User/UserAdminController/create/',
			update: '_api/User/UserAdminController/update/',
			destroy: '_api/User/UserAdminController/destroy/',
			read: '_api/User/UserAdminController/read/'
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