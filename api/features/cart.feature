Feature: Cart
  Before I checkout
  I want to see my cart and I need to be able to add/edit/delete products

  Scenario: Show Cart
    Given the cart exist
    And is not empty
    When I request "GET" "/api/carts/1"
    Then the response status code should be 200

  Scenario: Add product to cart
    Given the product "googlepixel7" exist
    And product is not in cart 1
    When I request "POST" "/api/carts/1/products/2"
    Then the response status code should be 201

  Scenario: Remove product from cart
    Given the product "poco5x" exist
    When I request "DELETE" "/api/carts/1/products/2"
    Then the response status code should be 204

  Scenario: Update product quantity in cart
    Given the product "poco5x" exist in cart "1"
    And I have the payload:
      """
      {
        "quantity": 16
      }
      """
    When I request "PUT" "/api/carts/1/products/1"
    Then the response status code should be 204
