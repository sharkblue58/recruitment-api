<?php

namespace Database\Seeders;

use App\Models\Skill;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SkillSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create system skills (predefined skills)
        $systemSkills = [
            // Programming Languages
            'PHP', 'Laravel', 'JavaScript', 'TypeScript', 'Vue.js', 'React', 'Angular', 'Node.js',
            'Python', 'Django', 'Flask', 'Java', 'Spring Boot', 'C#', '.NET', 'Ruby', 'Rails',
            'Go', 'Rust', 'Swift', 'Kotlin', 'C++', 'C', 'R', 'Scala', 'Clojure', 'Haskell',
            
            // Databases
            'MySQL', 'PostgreSQL', 'MongoDB', 'Redis', 'Elasticsearch', 'SQLite', 'Oracle',
            'SQL Server', 'Cassandra', 'Neo4j', 'DynamoDB', 'Firebase',
            
            // Cloud & DevOps
            'AWS', 'Azure', 'GCP', 'Docker', 'Kubernetes', 'Jenkins', 'GitLab CI', 'GitHub Actions',
            'Terraform', 'Ansible', 'Linux', 'Bash', 'PowerShell', 'Nginx', 'Apache',
            
            // Frameworks & Libraries
            'Express.js', 'NestJS', 'FastAPI', 'Spring', 'Hibernate', 'JPA', 'Entity Framework',
            'Symfony', 'CodeIgniter', 'CakePHP', 'Zend Framework', 'jQuery', 'Bootstrap',
            'Tailwind CSS', 'Sass', 'Less', 'Webpack', 'Vite', 'Parcel',
            
            // Tools & Technologies
            'Git', 'GitHub', 'GitLab', 'Bitbucket', 'Jira', 'Confluence', 'Slack', 'Trello',
            'Figma', 'Sketch', 'Adobe XD', 'Photoshop', 'Illustrator', 'VS Code', 'IntelliJ IDEA',
            'Eclipse', 'Sublime Text', 'Atom', 'Vim', 'Emacs',
            
            // Methodologies
            'Agile', 'Scrum', 'Kanban', 'DevOps', 'CI/CD', 'TDD', 'BDD', 'Microservices',
            'REST API', 'GraphQL', 'SOAP', 'OAuth', 'JWT', 'OAuth2', 'OpenID Connect',
            
            // Soft Skills
            'Leadership', 'Team Management', 'Project Management', 'Communication', 'Problem Solving',
            'Critical Thinking', 'Time Management', 'Adaptability', 'Creativity', 'Negotiation',
            'Presentation Skills', 'Mentoring', 'Cross-functional Collaboration', 'Strategic Planning',
            'Decision Making', 'Conflict Resolution', 'Customer Relations', 'Public Speaking',
            
            // Languages
            'English', 'Spanish', 'French', 'German', 'Italian', 'Portuguese', 'Chinese', 'Japanese',
            'Korean', 'Arabic', 'Russian', 'Hindi', 'Dutch', 'Swedish', 'Norwegian', 'Danish'
        ];

        foreach ($systemSkills as $skill) {
            Skill::create([
                'title' => $skill,
                'is_system_skill' => true,
            ]);
        }

        // Create some custom skills (user-defined)
        Skill::factory()
            ->custom()
            ->count(20)
            ->create();
    }
}