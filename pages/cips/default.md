---
title: cips
---

# Construct-a-CIP

---

### Preamble:

The process for CIP deployments has fundamentally changed with the rearrangement of environments. Now, with CIPs going from PVT to Prod2, the first-time submission of a CIP to the VSTS board is a de facto request for testing the deployment in the PVT environment. The changes here are designed to simplify the process and better relate the document to the stated goals of CAB.

#### What Developers should fill out:

- Activation or Non-Activation

- Does this qualify for a "Fast-Track"

- Change Summary "what"

- Change Summary "why"

- Risk Assessment

  - 0 - Fast Track

  - 1 - No impact expected

  - 2 - Minor, customer unnoticed performance impact

  - 3 - Customers may notice _minor_ performance issues

  - 4 - Single customer may face an outage or significant performance issues

  - 5 - Multiple customers may face an outage or significant performance issues

###### (Outage is defined as the inability to resolve a web page for more than 10 seconds, or more than one minute outside normal business hours)

###### (Significant performance issues is where any task's expected time of completion rises more than 50% in duration)

- Readiness for services:

  - Deployment Instructions
  - Need for PenTest?
  - Different actions per environment

- Testing guidelines, if any

- Relevant, related requests

- Dependencies

- Outage or performance degredation length

In addition, the deployment instructions need to be included, or preferably, linked.

! _All fields required always_

---

#### What Ops should fill out:

Deployment schedule in addition to the automatic dates in ticket.

Any considerations as it relates to outages and customer communication.

Reply to any expected or known delays.

---

#### Deployment process:

The process will be defined as outlined by ongoing CAB requirements.

As it relates specifically to instructions, the following process will be strongly suggested. While not fully required, deployment instructions would need to show reason for all exceptions as asked for by the Committee.

1. Any Preparatory steps for an implementor
2. Any Steps needed to verify or test the environment prior to deployment
3. Implementation Steps to be taken
4. Post-implementation success checks
5. List any performance or soak requirements
6. Rollback procedures if needed
7. Continuous monitoring if appropriate
8. If applicable, a success sign-off area for the implementor