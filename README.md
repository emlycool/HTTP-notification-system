# HTTP NOTIFICATION SYSTEM
This keeps tracks for topics and subcribers(endpoints) subscribed to particular topic. When a message is published on a topic, its forwarded to all subscriber endpoints.


## Setup Instruction
- composer install
- setup your env variables
- php artisan migrate --seed

## Endpoints
	 POST /subscribe/{topic}
- expected body 
	`{url: string}`
- response
	`{
	url: string, 
	topic: string
	}`

```POST /publish/{topic}```
- expected body 
``{
	[key: string]: any
}``



## Testing
`php artisan test`
