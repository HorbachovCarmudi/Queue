# Scenario

Imagine you are a software architect of a queueing system running on cloud instances.

The queueing system is an implementation of the pub/sub pattern, i.e. it allows producers to publish messages into a queueing storage, which are asynchronously fetched from the queue and processed by subscribing consumers.

Subscribing many consumers to the same queue (= a consumer group) allows load balancing the workload across the subscribed consumer instances.

Having operated the system for a while, you figured out that producers don't always publish a constant amount of messages, but rather publish in unpredictable rates that change over time.
In order to cope with this unpredictable workload, the system is running with much more consumers than would be necessary in average.

Consumers occupy cloud instances.
Because cloud instances are expensive, you decide to dynamically scale the number of consumers up and down according to the current workload (and thus save costs).

# Goal

The goal of this challenge is to simulate a system of a producer and a group of auto-scaled consumers connected by a queue.

The system should automatically balance the number of consumers in order to achieve three things:
* prevent the queue from running full
* keep processing latency as low as possible (so the queue should be as empty as possible)
* run as few consumers as possible depending on the current workload

The solution should allow observing the state of the system (size of the queue, number of consumers, etc.) while running the simulation.

Although the system in the scenario is described as being asynchronous, the overall solution should run the simulation synchronously in a single PHP process (no forking or multi-threading).

A test suite should be part of your solution.

# Constraints

## Producer

It is sufficient to simulate a single producer. The producer should publish messages in unpredictable patterns (e.g. randomly alternating message rates, bursts of messages, etc.). Pick one or two patterns that you think are suitable for the simulation.

## Queue

It is sufficient to simulate a single queue.
The queue should have a limited size and allow to buffer published messages until they are fetched by a consumer.
You should not require an actual queueing storage (like redis or rabbit) but rather simulate the queue instead.

## Simulation

The simulation should give insights into the scaling decisions being taken and the current state of the system (size of the queue, number of consumers, etc.) while running the simulation.

## Interface

It is sufficient to implement a minimal interface (like a CLI) in order to run the simulation.
Please provide brief instructions on how to run the simulation.

# Further ideas

Feel free to extend your solution further with your own ideas, e.g.:

* simulate consumer warmup delay (in order to simulate the spawn up time of cloud instances)
* support for many producers / many queues

**Note that none of these are necessary to solve the challenge.

# Hints

If necessary, you are allowed to use external libraries for auxiliary tasks (like logging, or CLI processing).

Feel free to make assumptions if the description of the challenge is unclear.

Focus on establishing a minimum viable solution first before considering any optimizations or optional features.
It is more important to deliver something that works and can be improved than something that doesn't work.

Once you a have viable solution, feel free to incorporate your own ideas (again, this is not necessary to solve the challenge though).

Have fun!
