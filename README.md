

##  NativeBrandsValidationTest

I began by first creating a route '/api/register' that would accept a POST request with the following parameters:

  * first_name
    * value
    * rules
  * last_name
    * value
    * rules  
  * email
    * value
    * rules
  * phone
      * value
      * rules
 
Afterwards wrote custom validation logic in a Class Called UserValidation in the Validators folder.

I also wrote a test to test the validation logic in the UserValidationTest class in the tests folder.

  
