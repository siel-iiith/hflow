hflow
=====

Hadoop visual workflows built on Oozie framework

The project is on Hadoop Visual Workflows. One can create a visual workflow of map jars , reduce jars, and map+reduce jars and start the hadoop workflows.
Jar files can be uploaded by end-users. We create a Oozie Xml which can be forwarded to a Oozie server. The server can then deploy hadoop sequence of required map-reduce tasks/jobs in the back-end.
We also have an in-house testing functionality in which we created a server on the machine. It listens to curl requests from the browser on a particular port and deploys the workflow in the machine itself.
The UI is simple drag and drop. Jar files are on a scrollable desk on top and can be dropped in the required order to create workflow. A workflow can be modified / deleted by delete ( red-cross ) button.


Particulars :
1. We used html , php, javascript and  ajax to implement the functionalities.
2. The sequence / flow of jobs is stored in /tmp/job ( see job.php ).
3. Input file by default is /tmp/note ( see server.py ) .
4. Final output/result by default is written in /var/www/cloud/result ( see server.py ) .
5. Folders maps/ , reds/ and mapred/ contain the default and uploaded jar files of respective types.
6. Temporary files and folders are created in hdfs, which are deletd on completion of workflow:
	1. /in		-	default input file
	2. /out		- 	default output folder
7. The oozie xml is created in the browser in the div with id='oozie-xml' , which can be used to forward to the server.


Installation :
1. The entire cloud folder has to be placed anywhere in the server accessible path. The changed to be done are :
	1. Path is to the folder has to be specified in '$homeDir' variable in main.php. Ex : In unix, it can be placed in /var/www and $homeDir would be '/var/www/cloud/' ( note the last '/' ). (Note: 'localhost' can be replaced by server IP ).
	2. In 'submit.php' , absolute path has to provided in '$path' , and '$home' will be same as $homeDir of main.php
	3. In server.py , path variable ( line number 11 ) has to be changed.

2. Port number can be changed in job.php and server.py if not free.



Assumptions :
1. The user will only upload working jar files, and in the proper location ( map, reduce or map-reduce jars ) .
2. Workflow is logistically correct. Example : output of one job can be the input of the next job. Oozie server should be looking into errors but our own hadoop backend doesn't , and will throw errors / exceptions . i
3.Hadoop is installed in '/usr/local/'


