pipeline {
     agent any
    stages {
            stage('Test') {
            steps {
                bat 'cd "C:\\OpenServer\\domains\\kursach" && C:\\OpenServer\\modules\\php\\PHP_7.1\\php.exe vendor\\bin\\phpunit tests > res.txt'
            }
            }

            stage('Check tests result') {
            steps {
            bat 'cd "C:\\OpenServer\\domains\\kursach" && findstr /C:"OK" res.txt'
            }
            }

            stage('Pack') {
            steps {
                bat 'cd "C:\\OpenServer\\domains\\kursach" && tar -c -f "%BUILD_FOLDER%\\%BUILD_NUMBER%.zip" "*"'
            }
        }
    }
}