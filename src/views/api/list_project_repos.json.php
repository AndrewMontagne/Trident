{
    "size": 1,
    "limit": 25,
    "isLastPage": true,
    "values": [{
        "slug": "test-repo",
        "id": 1,
        "name": "TEST REPO",
        "scmId": "git",
        "state": "AVAILABLE",
        "statusMessage": "Available",
        "forkable": true,
        "project": {
            "key": "PROJ",
            "id": 1,
            "name": "Project",
            "description": "Project Time",
            "public": false,
            "type": "NORMAL",
            "links": {
                "self": [{
                    "href": "http://localhost:7990/projects/PROJ"
                }]
            }
        },
        "public": false,
        "links": {
            "clone": [{
                "href": "http://andrew@localhost:7990/scm/proj/test-repo.git",
                "name": "http"
            }, {
                "href": "ssh://git@localhost:7999/proj/test-repo.git",
                "name": "ssh"
            }],
            "self": [{
                "href": "http://localhost:7990/projects/PROJ/repos/test-repo/browse"
            }]
        }
    }],
    "start": 0
}