# IXM Developer Skill Assessment

## Objective:
This assessment aims to evaluate your expertise in both frontend and backend Drupal development, as well as your general web development skills.

## Assignment Overview:

For this project, you'll be tasked with developing a landing page that incorporates several key features often encountered in our projects. The design for the landing page is provided [here](https://www.figma.com/design/uGmBtSv3LaG7QZnbRWBP5S/IXM-Developer-Skill-Assessment).

## Requirements:

* The project must be built using Bootstrap.
* Feel free to use any Drupal modules or make any architectural decisions you deem necessary.
* Implement small, frequent commits with clear and descriptive commit messages. Each commit should address a single feature.
* You should not spend more than 30 hours on this assignment. Please indicate the total time spent on each of the features in your README.md.
* Provide a copy of the database including the content used for the landing page.

## Landing Page Features:

### Header:

* The company logo.
* A customizable menu.
* A CTA (Call to Action) button.

### Hero Banner:
* A custom block that can be placed on any page.
* Users should be able to add a title, description, image, and CTA button.

### Services Section:
* A list of service cards that highlight different services.
* Each card should be customizable to be one of the 3 variants and should link to a page.

### Call to Action Block:
* A reusable custom block for calls to action.

### Our Process:
* An accordion-style list detailing our working process, with items that can be expanded and collapsed.

### Team Section:

* A block displaying team members.
* Data should be fetched from an external [API](https://dummyjson.com/docs).
* API integration must include authentication, and the block should allow configuration to select the number of team members displayed.

### Contact Form:
* A webform where users can email us.
* If the user selects the "Say Hi" option, an email should be sent to hi@example.com. If "Get a Quote" is selected, it should be sent to quotes@example.com.

### Footer:
* The company logo.
* A customizable menu.
* A list of social media links.
* Copyright information.

### Additional Notes:
* Focus on clean, maintainable code.
* Ensure the website is responsive and optimized for both desktop and mobile.

Good luck!


## Project Setup:
The project includes the foundational setup commonly used in IXM projects.

### Docker (Docksal)
You need the latest version of Docksal to run the environment. If you don't have Docksal installed, you can find installation instructions [here](https://docksal.io/installation).
After Docksal is installed you can run

```bash
fin init
```

### Database
This project includes a DB dump that should be restored after you set up your environment.

```bash
fin db import ./database/db.sql --progress
```
Once you finish your assessment you should create a dump of your DB and update the folder with your database.
```bash
fin db dump > database/db.sql
```
### Frontend
The project uses SDC and in case you have any additional questions please consult the `FRONTEND.MD`
