# Store using PHP, Api, React

We created a simple store. The backend developed using php and using mysql to work with datas. Frontend developed using react js.

**Note: Admin dashboard did not implemented!**

## Installation

### Clone project
First of all, we need to clone this repository.
Open your git bash (or powershell or terminal) and run this command:
```
git clone https://github.com/sajjadGhl/Store-using-php-api-react.git
```

### BackEnd
First you need to create a database at first.
start your ```Apache``` and ```MySql``` service and create a new database.

Then, go to ```API/Database``` and open ```config.php``` file.
Specify desired token for your self. It can be anything.
Then edit db information and put yours.

Save the file.

Now open your browser and execute ```API/install/``` for creating tables and seeding database automatically.

API is ready.


### FrontEnd

First of all, you need to set your API base url.
Go to ```FrontEnd/src/services/api.js``` file and edit:
```
axios.defaults.baseURL = 'https://api.sajjadghl.ir';
```
Put your base url in here.

Next step is installing required packages.
Open cmd (or powershell or terminal) and go inside the working directory. (FrontEnd folder)

Just execute below command:
```
npm install
```

After that, you have to build the project so you can share it.
Execute this command:
```
npm build
```

You can upload ```dist``` folder to your host and thats all.


## Screenshots

**Index Page**

![Index Page](https://biaupload.com/do.php?imgf=org-17b24fc924ce3.png)

---

**Signup Page**

![Signup Page](https://biaupload.com/do.php?imgf=org-b093589237413.png)

---

**Login Page**

![Login Page](https://biaupload.com/do.php?imgf=org-eb2325bdef974.png)

---

**Products Page**

![Products Page](https://biaupload.com/do.php?imgf=org-3954271192cc1.png)

---

**Profile Page**

![Profile Page](https://biaupload.com/do.php?imgf=org-66d63850c61f2.png)

---

**Edit Profile Page**

![Edit Profile Page](https://biaupload.com/do.php?imgf=org-666b08cd620f2.png)

---

**Cart Page**

![Cart Page](https://biaupload.com/do.php?imgf=org-543efa9d44e71.png)

