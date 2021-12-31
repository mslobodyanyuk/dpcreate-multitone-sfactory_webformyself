Lesson 2. Design patterns. Multitone. Static Factory
====================================================

* ***Actions on the deployment of the project:***

- Making a new project dpcreate-multitone-sfactory_webformyself.loc:
																	
	sudo chmod -R 777 /var/www/DESIGN_PATTERNS/Creational/dpcreate-multitone-sfactory_webformyself.loc

	//!!!! .conf
	sudo cp /etc/apache2/sites-available/test.loc.conf /etc/apache2/sites-available/dpcreate-multitone-sfactory_webformyself.loc.conf
		
	sudo nano /etc/apache2/sites-available/dpcreate-multitone-sfactory_webformyself.loc.conf

	sudo a2ensite dpcreate-multitone-sfactory_webformyself.loc.conf

	sudo systemctl restart apache2

	sudo nano /etc/hosts

	cd /var/www/DESIGN_PATTERNS/Creational/dpcreate-multitone-sfactory_webformyself.loc

- Deploy project:

	`git clone << >>`
	
	`or Download`
	
	_+ Сut the contents of the folder up one level and delete the empty one._

---

WebForMySelf

[Lesson 2. Design patterns. Multitone. Static Factory (34:41)]( https://www.youtube.com/watch?v=sWA1yVl8gDY&ab_channel=WebForMySelf )

Continuation of the course on design patterns here: 
<https://webformyself.com/category/premium/php-premium/patterns-premium/>

In the last lesson, we examined the Singleton design pattern and found out that this pattern guarantees a single instance for a certain class.
But there are situations when it is necessary to create several named objects of a certain class, and each named object must be unique and unique.
In this case, Singletone cannot be used, which means that we will consider a certain variation of this pattern, which was isolated as a separate template and named Multitone.
Let's also take a look at a rather interesting pattern that generates a pattern called a static factory.

Following the results of this lesson, you will learn how to create a certain number of named objects using the Multitone pattern.
And also, using the example of a static factory, you will see how intermediate classes are created whose task is to create and return objects of other classes.

Multitone
=========

[(0:30)]( https://youtu.be/sWA1yVl8gDY?t=30 ) In this lesson, we will look at a variation of the Singletone Pattern called Multitone and begin to get acquainted with the Factory Patterns group.
Why do I say group because there are several Patterns such as
- Static Factory
- Simple Factory
- Abstract Factory
- Factory Method
Which, by and large, perform very similar actions.

[(1:15)]( https://youtu.be/sWA1yVl8gDY?t=75 ) `Multitone`. 

What is its difference and similarity with the `Singletone` Pattern. - In fact, the `Singletone` Pattern provides us with a unique concrete object of a certain class. BUT, very often it happens that it is necessary to use the same class for different objects.

[(1:40)]( https://youtu.be/sWA1yVl8gDY?t=100 ) For example, IF we are implementing a certain framework, then we can have 2 connections to the database, for example, `MySQL` and `SQLite`. OR IF we are writing a file, a class for saving information to a file,
that is, for example, it can be a logging class, then we can write various logs, both system and user. And we need 2 objects of this class so that we create 2 different files.
The `Multitone` pattern allows us to define a certain number of objects of a specified class. Moreover, these will be named objects. The explanation itself suggests that IF we will form a certain fixed number of objects of a specific class,
And moreover, these objects must be named, then, of course, these objects must be stored somewhere.

[(2:40)]( https://youtu.be/sWA1yVl8gDY?t=160 ) In `Singletone`, we used the static property `$ _instance`, which stores an object of a specific class. - Of course, this property is NOT suitable for the `Multitone` Pattern because
how it can store ONLY one single object, but we have several objects.
 
[(3:05)]( https://youtu.be/sWA1yVl8gDY?t=185 ) You will meet `Multitone` much less often because it somehow contradicts the wording of `Singletone`, BUT it still takes some functionality from it.

[(3:35)]( https://youtu.be/sWA1yVl8gDY?t=215 ) `Coding.`

```
classes					- folder with Pattern classes
	Multitone			- the folder contains a class that implements the Multitone Pattern.
		FileSave.php	- is a class that implements the Multitone Pattern.
functions.php			- file with class connection function
index.php				- entry point
```

In `FileSave.php`:

```php
namespace Multitone;
...
private static $_instance = [];
...
private function __construct($str){
	$this->filePath = $str.'-'.md5(microtime()).'.txt';		
...
```

[(5:00)]( https://youtu.be/sWA1yVl8gDY?t=300 ) `__constructor().`
In the constructor we define a certain path that we will use to form the `filePath` property. IF we are talking about the Creation of several objects, we will pass the `$str` parameter to the constructor, and this string will be added to the file name.

[(5:40)]( https://youtu.be/sWA1yVl8gDY?t=340 ) IF the constructor takes a parameter, then the `getInstanse()` method must accept the given argument as a parameter. The signature of the methods in the `Multitone` Pattern already depends ONLY on your implementation.
The main condition is private constructors and the use of a method that will provide the ability to Create an object of a specific class. - And, accordingly, Implementation is absolutely at your discretion.

[(6:45)]( https://youtu.be/sWA1yVl8gDY?t=405 ) IF DOES NOT exist in the array `$ _instance[]` a cell named `$str`, that is, when creating a class object, calling the `getInstance()` method for execution, we will pass it as the first argument,
just the same, the name of the object that we can create OR get.

```php
	public static function getInstance($str) : FileSave {
				
		//instanceof if( !self::$_instance instanceof self )
        if(!isset(self::$_instance[$str])){
			self::$_instance[$str] = new static($str); //(Late Static Binding, LSB) 
		}
		return self::$_instance[$str];
	}
...

[(8:55)]( https://youtu.be/sWA1yVl8gDY?t=535 ) `index.php`.

```php
use Multitone\FileSave;

require "functions.php";
spl_autoload_register('project_autoload');

$file = FileSave::getInstance('user-logs');
$file->save(__DIR__);

$file = FileSave::getInstance('system-logs');
$file->save(__DIR__);

$file = FileSave::getInstance('user-logs');
$file->save(__DIR__);

$file = FileSave::getInstance('system-logs');
$file->save(__DIR__);
```

[(10:10)]( https://youtu.be/sWA1yVl8gDY?t=610 ) `In Browser`.

	http://dpcreate-multitone-sfactory_webformyself.loc/

![screenshot of sample]( https://github.com/dpcreate-multitone-sfactory_webformyself/blob/main/public/images/firefox.png )

_Go to the root of our project and see two files._

![screenshot of sample]( https://github.com/mslobodyanyuk/dpcreate-multitone-sfactory_webformyself/blob/main/public/images/xubuntu.png )

`system-logs`:

```
 text text
``` 

_The line of text was duplicated two times._

`user-logs`:

![screenshot of sample]( https://github.com/mslobodyanyuk/dpcreate-multitone-sfactory_webformyself/blob/main/public/images/kate.png )

```
 text text
``` 

_Also, a line of text was duplicated twice._

[(10:25)]( https://youtu.be/sWA1yVl8gDY?t=625 ) That is, we call one object 2 times, 2 times the second and, accordingly, we see the specified string is duplicated 2 times. - Thus, you can control the number of Created objects. - Yes, you can add many different improvements here.
That is, we can declare specific constants that will store the types of the Created objects OR the names of the Created objects and, thus, when creating a specific element, check IF the passed element matches the specified type, then ONLY
then Create an object of this class OR Return it. - IF a match is NOT found, then we can generate an Exception.

And also in this Pattern, the method for Removing objects from the array `$ _instance[]` is sometimes prescribed. That is, IF the array `$ _instance[]` stores a certain number of elements for us, then we may have to Delete elements from this array.

[(11:35)]( https://youtu.be/sWA1yVl8gDY?t=695 ) Again, EVERYTHING is Implementation specific. You can create a method `removeInstance($instanceName)`.

```php 
public static function removeInstance($instanceName)
{	
	if(array_key_exists($instanceName, static::$instances)){
		unset(static::$_instance[$instanceName]);
	}
}
```

---

Static Factory
==============

[(12:20)]( https://youtu.be/sWA1yVl8gDY?t=740 ) `Static Factory`. The easiest way to implement Patterns of the specified group, the Patterns Factory group. The `FileSave` in `Singletone` and in `Multitone` is a very simple class that performs an action.
Interested in those actions that should be performed when creating an object of the class. We see that when creating a class object, one single simple action is performed, the `FilePath` property is initialized.

[(13:25)]( https://youtu.be/sWA1yVl8gDY?t=805 ) Suppose that when creating a specific object, these are the actions that must be performed during its Creation are quite complicated And, of course, IF there are many such actions, then it is NOT rational, NOT correct to store them in one method.
you need to move EVERYTHING into separate methods. It is also possible when creating an object of a specific class, interaction with third-party Services is carried out. That is, a connection is implemented, possibly to some Services, receiving data OR sending data, and so on.
Thus, the set of such actions can be very, very large, they, of course, can be carried out in separate methods. In such classes, as a rule, initialization is rather complicated. It requires calling certain additional methods.
It may also be necessary to summon something else. That is, before creating an object of a class, it is necessary, perhaps, to Create objects of some other interacting classes. And then pass them directly to the constructor. - The methods can be completely different.
My point is that some classes require a certain way to create their objects. BUT, IF on c has, for example, a specific class and some third-party Developer Creates its object, then, by and large, he may NOT know how to correctly Create an object
specific class. - What needs to be called to correctly Create objects of a specific class. Ok, IF there is a `Singletone` - it Called` getInstance () `.
IF `Singletone` is NOT, it simply writes `new ConcreteClass` and Constructs an object of a specific class and may receive Errors.

[(15:15)]( https://youtu.be/sWA1yVl8gDY?t=915 ) So, just the same, this is the problem that Patterns from the Factory group solve.
That is, the problem lies in the fact that for certain classes it is necessary to define a certain general way of creating their objects. - Otherwise, the object may be Created incorrectly, Errors may occur.

[(15:45)]( https://youtu.be/sWA1yVl8gDY?t=945 ) Patterns of the Factory group define the general interface for creating objects in a certain class. The essence of these Patterns is that there is a certain Mediator class that Creates an object of a certain required class. - Moreover, it correctly Creates this object.
It calls those methods for execution, which are necessary for the correct creation of the object. And now, a third-party Developer to Create the desired object simply refers to this Mediator class, Calls a method that is used to Create objects and the object is Created.
And, accordingly, this object is Created correctly. The Developer may not even know the code of this Mediator class.

[(17:55)]( https://youtu.be/sWA1yVl8gDY?t=1075 ) `Coding.`

[(18:40)]( https://youtu.be/sWA1yVl8gDY?t=1120 ) Using the interface, we can control the structure of certain classes. The interface lays down the general implementation of the concrete classes that implement it.

```
classes						- folder with Pattern classes
	StaticFabric			- the folder contains a class that implements the Static Factory Pattern.
		FactoryClass.php	- is a class whose objects you want to Create.
		IFactory.php		- interface that the FactoryClass class should implement.
		StaticFactory.php	- the actual class of the Static Factory that Creates the objects.
index.php					- entry point
```

[(22:40)]( https://youtu.be/sWA1yVl8gDY?t=1360 ) `StaticFactory.php`. - This class will act as a Mediator for the Creation of an object of the required class.
Its Realization can also be absolutely arbitrary. - The main thing is that this class is Mediator, this Factory should simply return an object of a certain required class on-demand.

[(23:15)]( https://youtu.be/sWA1yVl8gDY?t=1395 ) As for Inheritance OR Implementations, as a rule, this is NOT used. BUT, IF you have a certain parent Factory, we can Inherit it. - BUT hardly, as a rule, `Static Factory` is one specific class.
Here we need ONLY one method. - This is in a simplified sense. IF you have some complex way of forming an object, then you may need several methods. In general, only one public static method is needed.
Static because that's what the `Static Factory` Pattern Definition defines. That is, we are implementing a certain static interface for creating objects of specific classes.

[(24:10)]( https://youtu.be/sWA1yVl8gDY?t=1450 ) We must create a public method because this method will be accessed from the outside.

[(24:30)]( https://youtu.be/sWA1yVl8gDY?t=1470 ) As for the passed arguments, as a rule, a certain type of the Created object is passed in the form of a string. That is, EITHER the name, OR the type. Again, EVERYTHING depends on the Implementation.
You can specify the type of Returned Data. - We have an interface `IFactory` and, just the same, the class that will Return the object must implement this interface. - Accordingly, IF some other object is returned, then we will receive an Exception.

```php 
namespace StaticFabric;

class StaticFactory{

    public static function create(string $type) : IFactory {
        return new $type();
    }

}
```

[(25:30)]( https://youtu.be/sWA1yVl8gDY?t=1530 ) You can enumerate as subsequent arguments those parameters that will be passed to the constructor of the object of the Created class, EVERYTHING depends on the current Implementation.

[(26:10)]( https://youtu.be/sWA1yVl8gDY?t=1570 ) `index.php`.

```php
use StaticFabric\StaticFactory;
require "functions.php";
spl_autoload_register('project_autoload');

$obj = StaticFactory::create('\StaticFabric\FactoryClass');
$obj->save();
```

[(30:35)]( https://youtu.be/sWA1yVl8gDY?t=1835 ) `Refresh Browser(F5).`- Actually, we implemented the `Static Factory` Pattern.

![screenshot of sample]( https://github.com/dpcreate-multitone-sfactory_webformyself/blob/main/public/images/firefox1.png )

```
save data
```

[(30:50)]( https://youtu.be/sWA1yVl8gDY?t=1850 ) Suppose the `Static Factory` Pattern is used to create objects of a certain class. That is, it is the Mediator class, which is used to properly Create objects of a particular class with which it works.
Moreover, its implementation can be absolutely and completely different. EVERYTHING depends on the Tasks that your project implements.

[(31:15)]( https://youtu.be/sWA1yVl8gDY?t=1875 ) There is a practice when a certain check is done with a specific string, which determines the type of this object and we create an object of the class that interests.
That is, here you define the set of methods and the functionality that is necessary for the correct Creation of the object.

[(32:20)]( https://youtu.be/sWA1yVl8gDY?t=1940 ) Thus, when creating an object of a specific class, a specific User does NOT create an object using `new`. - He refers to the Static Factory class we provide him.
It Calls a specific method of this class that is used to Create objects and passes, for example, EITHER the type of the class OR, as in our case, the name of a particular class, the object of which he wants to Create.
And, accordingly, the static method of this class that implements the `Static Factory` - Returns the created object in a concrete and correct way. Repeatedly repeating that the Realization can be completely different.
Next are `Simple Factory`, `Factory Method`, and `Abstract Factory`. By and large, ALL of these Patterns implement the same thing. They Create an object.
That is, these are the Intermediary classes that Create the object. BUT, the implementation is completely different and the approach is slightly different.

#### Useful links:

WebForMySelf

[Lesson 2. Design patterns. Multitone. Static Factory]( https://www.youtube.com/watch?v=sWA1yVl8gDY&ab_channel=WebForMySelf )

<https://webformyself.com/category/premium/php-premium/patterns-premium/>