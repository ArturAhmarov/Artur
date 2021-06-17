pipeline {
     agent any
    stages {
            stage('Pack') {
            steps {
                bat 'cd "C:\\OpenServer\\domains\\kursach" && tar -c -f "%BUILD_FOLDER%\\%BUILD_NUMBER%.zip" "*"'
            }
        }
    }
}