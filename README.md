IBM MTM World Championship Bank App
========================

This is the bank application that we had to develop during
the IBM MTM World Championship contest held on NYC on 2014.

I decided to use Symfony 2 to develop the application and to
focus on security concerns and on a friendly interface
rather than on extra functionalities.

Due to the strong deadlines and lack of time, the current code
needs some refactoring to provide a real service-oriented
architecture.

On a real-world bank application there should also be a
message queue system, to provide scalibility and reliablity and
a transaction server to manage high loads of transactions.
