{
    "responseId": "90bdf3af-7884-4b70-8c42-32cbeb853a19",
    "queryResult": {
        "queryText": "FACEBOOK_MEDIA",
        "parameters": [],
        "allRequiredParamsPresent": true,
        "fulfillmentMessages": [
            {
                "text": {
                    "text": [
                        ""
                    ]
                }
            }
        ],
        "outputContexts": [
            {
                "name": "projects\/bot-demo-4d232\/agent\/sessions\/8cfa14d4-3537-4afa-94e1-f5b08a869192\/contexts\/facebook_media"
            },
            {
                "name": "projects\/bot-demo-4d232\/agent\/sessions\/8cfa14d4-3537-4afa-94e1-f5b08a869192\/contexts\/generic",
                "lifespanCount": 4,
                "parameters": {
                    "facebook_sender_id": "1076283829163074"
                }
            }
        ],
        "intent": {
            "name": "projects\/bot-demo-4d232\/agent\/intents\/d76b37fc-d954-4a86-8f49-2843c6b13087",
            "displayName": "imagen"
        },
        "intentDetectionConfidence": 1,
        "languageCode": "es"
    },
    "originalDetectIntentRequest": {
        "source": "facebook",
        "payload": {
            "data": {
                "sender": {
                    "id": "1076283829163074"
                },
                "recipient": {
                    "id": "301735143750953"
                },
                "message": {
                    "attachments": [
                        {
                            "payload": {
                                "url": "https:\/\/scontent.xx.fbcdn.net\/v\/t1.15752-9\/44980881_2396912037016338_2585147133359292416_n.jpg?_nc_cat=108&_nc_ad=z-m&_nc_cid=0&_nc_ht=scontent.xx&oh=03dbc06084fa84ece22c13d6ae44e84f&oe=5C3F7A00"
                            },
                            "type": "image"
                        }
                    ],
                    "mid": "87xror4H2gVeZKUexDlhxXsz8f-G-Au6ANyR6cxRQEp-874_iNxTKVbQdMHjegK6UHhUKoqdGJWCsancgQj_gA",
                    "seq": 2983
                },
                "timestamp": 1540779486333
            },
            "source": "facebook"
        }
    },
    "session": "projects\/bot-demo-4d232\/agent\/sessions\/8cfa14d4-3537-4afa-94e1-f5b08a869192"
}