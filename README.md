# Welcome to Session Bag
***SessionBag*** is a lightweight and convenient package for interacting with PHP sessions. With an easy-to-use API, you can start, check, store, retrieve, and flash data from the session effortlessly.

SessionBag makes session management as simple as reaching into a bag and pulling out exactly what you need, whether it's persistent data or temporary flash messages.

### How-To

***Initialize the session***
```PHP
   $session = new Session();
```

***Start the session***
```PHP
   $session->start();
```

***Check if a value exists***
```PHP
   $session->has("errors");
```

***Push a value into the session***
```PHP
   $session->push("email", "example@domain.com");
```

***Retrieve a value***
- Return null (or a specified value) as default if the value doesn't exist.
```PHP
   $default = null;
   $session->get("errors", $default);
```

***Flashing a message to a session***
```PHP
   $session->flash('status', 'Your profile has been updated.');
```

***Retrieving and Removing a Flash Message***
 - This will remove the message from the session after retrieving it.
```PHP
   $session->getFlash('status');
```

***Prevent flash data from being removed***
- Keep flash data alive for the next request
```PHP
   // Prevent all the flash data from being removed
   $session->reflash();

   // Prevent specific flash message(s) from being removed
   $session->reflash(['email', 'username']);
```

### Reflash example
```PHP
   $data = [
    'username' => 'example',
    'email' => 'example@domain.com',
  ];
  
  // Flash the data into the session
  $session->flash('username', $data['username']);
  $session->flash('email', $data['email']);
  
  // Reflash only the 'email' key, keeping it for the next request
  $session->reflash(['email']);
  
  // Now, let's retrieve the flashed data:
  echo $session->getFlash('username'); // Outputs: example
  echo $session->getFlash('email');    // Outputs: example@domain.com
  
  // At this point, only 'email' remains in the flash data, 
  // 'username' is no longer available for future requests.
```
