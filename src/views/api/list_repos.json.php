{
    "size": 2,
    "limit": 25,
    "isLastPage": true,
    "values": [{
        "slug": "hkjdshflkjdhfs",
        "id": 2,
        "name": "hkjdshflkjdhfs",
        "scmId": "git",
        "state": "AVAILABLE",
        "statusMessage": "Available",
        "forkable": true,
        "project": {
            "key": "~ANDREW",
            "id": 2,
            "name": "andrew",
            "type": "PERSONAL",
            "owner": {
                "name": "andrew",
                "emailAddress": "andrewmontagne@gmail.com",
                "id": 1,
                "displayName": "andrew",
                "active": true,
                "slug": "andrew",
                "type": "NORMAL",
                "links": {
                    "self": [{
                        "href": "http://localhost:7990/users/andrew"
                    }]
                }
            },
            "links": {
                "self": [{
                    "href": "http://localhost:7990/users/andrew"
                }]
            }
        },
        "public": true,
        "links": {
            "clone": [{
                "href": "ssh://git@localhost:7999/~andrew/hkjdshflkjdhfs.git",
                "name": "ssh"
            }, {
                "href": "http://andrew@localhost:7990/scm/~andrew/hkjdshflkjdhfs.git",
                "name": "http"
            }],
            "self": [{
                "href": "http://localhost:7990/users/andrew/repos/hkjdshflkjdhfs/browse"
            }]
        }
    }, {
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