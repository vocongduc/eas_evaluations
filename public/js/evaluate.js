function myFunction() {
    let mainPointIds = document.querySelectorAll(".main-point-id")
    mainPointIds.forEach((mainItem, mainIndex) => {
        let mainItemId = mainItem.value
        let items = document.querySelectorAll(".point-" + mainItemId);
        let totalPoint = document.querySelectorAll('.total-point-' + mainItemId)
        let weightPoints = document.querySelectorAll('.weight-point-' + mainItemId)
        let totalCriteriaPoint = document.querySelector('.total-criteria-point-' + mainItemId)
        let dataTotalPoint = []
        items.forEach((item, index) => {
            totalPoint[index].value = item.value * weightPoints[index].textContent
            dataTotalPoint.push(parseInt(totalPoint[index].value, 10))
            totalCriteriaPoint.textContent = dataTotalPoint.reduce((a, b) => a + b, 0)
        })
    })
}

function sumAdminPoint() {
    // Sum member point
    let mainPointIds = document.querySelectorAll(".main-point-id")
    mainPointIds.forEach((mainItem, mainIndex) => {
        let mainItemId = mainItem.value
        let items = document.querySelectorAll(".point-" + mainItemId);
        const totalPoint = document.querySelectorAll('.total-point-' + mainItemId)
        const totalCriteriaPoint = document.querySelector('.total-criteria-point-' + mainItemId)
        let dataTotalPoint = []
        items.forEach((item, index) => {
            dataTotalPoint.push(parseInt(totalPoint[index].value, 10))
            totalCriteriaPoint.textContent = dataTotalPoint.reduce((a, b) => a + b, 0)
        })
    })

}

function admin() {
    let mainPointIds = document.querySelectorAll(".main-point-id")
    mainPointIds.forEach((mainItem, mainIndex) => {
        let mainItemId = mainItem.value
        let totalCris = document.getElementsByClassName('total-cri-point-' + mainItemId);
        let totalMain = document.querySelector('.total-main-point-' + mainItemId);
        let count = totalCris.length - 1;
        let dataTotalCrisPoint = []
        for (let i = 0; i <= count; i++) {
            dataTotalCrisPoint.push(parseInt(totalCris[i].textContent, 10))
            totalMain.textContent = dataTotalCrisPoint.reduce((a, b) => a + b, 0)
        }
    })
}

function adminPoint2() {
    let mainPointIds = document.querySelectorAll(".main-point-id")
    mainPointIds.forEach((mainItem, mainIndex) => {
        let mainItemId = mainItem.value
        let items = document.querySelectorAll(".point-" + mainItemId);
        let totalPoint = document.querySelectorAll('.total-point-' + mainItemId)
        let weightPoints = document.querySelectorAll('.weight-point-' + mainItemId)
        let totalCriteriaPoint = document.querySelector('.total-criteria-point-' + mainItemId)
        let dataTotalPoint = []
        items.forEach((item, index) => {
            totalPoint[index].value = item.value * weightPoints[index].textContent
            dataTotalPoint.push(parseInt(totalPoint[index].value, 10))
            totalCriteriaPoint.textContent = dataTotalPoint.reduce((a, b) => a + b, 0)
        })
    })
}

function mentorPoint() {
    let mainPointIds = document.querySelectorAll(".main-point-id")
    mainPointIds.forEach((mainItem, mainIndex) => {
        let mainItemId = mainItem.value
        let items = document.querySelectorAll(".mentor-point-" + mainItemId);
        const totalPoint = document.querySelectorAll('.total-mentor-point-' + mainItemId)
        const weightPoints = document.querySelectorAll('.weight-point-' + mainItemId)
        const totalCriteriaPoint = document.querySelector('.total-criteria-point-mentor-' + mainItemId)
        let dataTotalPoint = []
        items.forEach((item, index) => {
            totalPoint[index].value = item.value * weightPoints[index].textContent
            dataTotalPoint.push(parseFloat(totalPoint[index].value))
            totalCriteriaPoint.textContent = dataTotalPoint.reduce((a, b) => a + b, 0)
        })
    })
}

function sumMentorPoint() {
    // Sum member point
    let mainPointIds = document.querySelectorAll(".main-point-id")
    mainPointIds.forEach((mainItem, mainIndex) => {
        let mainItemId = mainItem.value
        let items = document.querySelectorAll(".mentor-point-" + mainItemId);
        const totalPoint = document.querySelectorAll('.total-mentor-point-' + mainItemId)
        const totalCriteriaPoint = document.querySelector('.total-criteria-point-mentor-' + mainItemId)
        let dataTotalPoint = []
        items.forEach((item, index) => {
            dataTotalPoint.push(parseFloat(totalPoint[index].value))
            totalCriteriaPoint.textContent = dataTotalPoint.reduce((a, b) => a + b, 0)
        })
    })
}

function mentor() {
    let mainPointIds = document.querySelectorAll(".main-point-id")
    mainPointIds.forEach((mainItem, mainIndex) => {
        let mainItemId = mainItem.value
        let totalCris = document.getElementsByClassName('total-cri-point-' + mainItemId);
        let totalMain = document.querySelector('.total-main-point-' + mainItemId);
        let count = totalCris.length - 1;
        let dataTotalCrisPoint = []
        for (let i = 0; i <= count; i++) {
            dataTotalCrisPoint.push(parseFloat(totalCris[i].textContent))
            totalMain.textContent = dataTotalCrisPoint.reduce((a, b) => a + b, 0)
        }
    })
}

function mentorPoint2() {
    let mainPointIds = document.querySelectorAll(".main-point-id")
    mainPointIds.forEach((mainItem, mainIndex) => {
        let mainItemId = mainItem.value
        let items = document.querySelectorAll(".mentor-point-" + mainItemId);
        const totalPoint = document.querySelectorAll('.total-mentor-point-' + mainItemId)
        const weightPoints = document.querySelectorAll('.weight-point-' + mainItemId)
        const totalCriteriaPoint = document.querySelector('.total-criteria-point-mentor-' + mainItemId)
        let dataTotalPoint = []
        items.forEach((item, index) => {
            totalPoint[index].value = item.value * weightPoints[index].textContent
            dataTotalPoint.push(parseFloat(totalPoint[index].value))
            totalCriteriaPoint.textContent = dataTotalPoint.reduce((a, b) => a + b, 0)
        })
    })
}

function sumMemberPoint() {
    // Sum member point
    let mainPointIds = document.querySelectorAll(".main-point-id")
    mainPointIds.forEach((mainItem, mainIndex) => {
        let mainItemId = mainItem.value
        let items = document.querySelectorAll(".member-point-" + mainItemId);
        const totalPoint = document.querySelectorAll('.total-member-point-' + mainItemId)
        const totalCriteriaPoint = document.querySelector('.total-criteria-point-member-' + mainItemId)
        let dataTotalPoint = []
        items.forEach((item, index) => {
            dataTotalPoint.push(parseInt(totalPoint[index].value, 10))
            totalCriteriaPoint.textContent = dataTotalPoint.reduce((a, b) => a + b, 0)
        })
    })
}


function memberPoint() {
    let mainPointIds = document.querySelectorAll(".main-point-id")
    mainPointIds.forEach((mainItem, mainIndex) => {
        let mainItemId = mainItem.value
        let items = document.querySelectorAll(".member-point-"+mainItemId);
        const totalPoint = document.querySelectorAll('.total-member-point-'+mainItemId)
        const weightPoints = document.querySelectorAll('.weight-point-'+mainItemId)
        const totalCriteriaPoint = document.querySelector('.total-criteria-point-member-'+mainItemId)
        let dataTotalPoint = []
        items.forEach((item, index) => {
            totalPoint[index].value = item.value * weightPoints[index].textContent
            dataTotalPoint.push(parseInt(totalPoint[index].value))
            totalCriteriaPoint.textContent = dataTotalPoint.reduce((a, b) => a + b, 0)
        })
    })
}


function memberPoint2() {
    let mainPointIds = document.querySelectorAll(".main-point-id")
    mainPointIds.forEach((mainItem, mainIndex) => {
        let mainItemId = mainItem.value
        let items = document.querySelectorAll(".member-point-"+mainItemId);
        const totalPoint = document.querySelectorAll('.total-member-point-'+mainItemId)
        const weightPoints = document.querySelectorAll('.weight-point-'+mainItemId)
        const totalCriteriaPoint = document.querySelector('.total-criteria-point-member-'+mainItemId)
        let dataTotalPoint = []
        items.forEach((item, index) => {
            totalPoint[index].value = item.value * weightPoints[index].textContent
            dataTotalPoint.push(parseInt(totalPoint[index].value))
            totalCriteriaPoint.textContent = dataTotalPoint.reduce((a, b) => a + b, 0)
        })
    })
}


function sumTeamPoint() {
    // Sum member point
    let mainPointIds = document.querySelectorAll(".main-point-id")
    mainPointIds.forEach((mainItem, mainIndex) => {
        let mainItemId = mainItem.value
        let items = document.querySelectorAll(".team-point-" + mainItemId);
        const totalPoint = document.querySelectorAll('.total-point-team-' + mainItemId)
        const totalCriteriaPoint = document.querySelector('.total-criteria-point-team-' + mainItemId)
        let dataTotalPoint = []
        items.forEach((item, index) => {
            dataTotalPoint.push(parseFloat(totalPoint[index].value))
            totalCriteriaPoint.textContent = dataTotalPoint.reduce((a, b) => a + b, 0)
        })
    })
}

function sumPointUser(){
    const totalMainPoints = document.querySelectorAll('.total-main-point')
    let totalPointUser = document.querySelector(".total-point-user");
    const pointCharacter = document.querySelector('.point-character')
    let dataTotalPoint = []
    totalMainPoints.forEach((totalMainPoint => {
        dataTotalPoint.push((parseInt(totalMainPoint.textContent)))

    }))
    totalPointUser.textContent = dataTotalPoint.reduce((a, b) => a + b, 0)
    let score = totalPointUser.textContent

    if( score <= 0) {
        pointCharacter.innerHTML = "C"
    }else if( score <= 299) {
        pointCharacter.innerHTML = "C"
    }else if( score <= 399){
        pointCharacter.innerHTML = "B-"
    }else if( score <= 599){
        pointCharacter.innerHTML = "B"
    }else if( score <= 799){
        pointCharacter.innerHTML = "B+"
    }
    else if( score <= 949){
        pointCharacter.innerHTML = "A"
    }else {
        pointCharacter.innerHTML = "S"
    }
}

function getPointMember() {
    let mainPointIds = document.querySelectorAll(".main-point-id");
    let mainPoint = document.querySelector(".mainPointId");
    let totalPoint = document.querySelector(".totalPoint");
    let idMainPoints = []
    let pointMains = []
    mainPointIds.forEach((mainItem, mainIndex) => {
        let mainItemId = mainItem.value
        let totalPointMain = document.querySelectorAll(".total-point-criteria-member-"+mainItemId);
        totalPointMain.forEach((item, index) => {
            pointMains.push(parseInt(item.textContent, 10))
        })
        idMainPoints.push(parseInt(mainItemId, 10))
    })
    mainPoint.value = idMainPoints;
    totalPoint.value = pointMains;
}
function getPointMentor() {
    let mainPointIds = document.querySelectorAll(".main-point-id");
    let mainPoint = document.querySelector(".mainPointId");
    let totalPoint = document.querySelector(".totalPoint");
    let idMainPoints = []
    let pointMains = []
    mainPointIds.forEach((mainItem, mainIndex) => {
        let mainItemId = mainItem.value
        let totalPointMain = document.querySelectorAll(".total-point-criteria-mentor-"+mainItemId);
        totalPointMain.forEach((item, index) => {
            pointMains.push(parseInt(item.textContent, 10))
        })
        idMainPoints.push(parseInt(mainItemId, 10))
    })
    mainPoint.value = idMainPoints;
    totalPoint.value = pointMains;
}
function getPointAdmin() {
    let mainPointIds = document.querySelectorAll(".main-point-id");
    let mainPoint = document.querySelector(".mainPointId");
    let totalPoint = document.querySelector(".totalPoint");
    let idMainPoints = []
    let pointMains = []
    mainPointIds.forEach((mainItem, mainIndex) => {
        let mainItemId = mainItem.value
        let totalPointMain = document.querySelectorAll(".total-point-criteria-admin-"+mainItemId);
        totalPointMain.forEach((item, index) => {
            pointMains.push(parseInt(item.textContent, 10))
        })
        idMainPoints.push(parseInt(mainItemId, 10))
    })
    mainPoint.value = idMainPoints;
    totalPoint.value = pointMains;
    console.log(pointMains)
}

function member() {
    let mainPointIds = document.querySelectorAll(".main-point-id")
    mainPointIds.forEach((mainItem, mainIndex) => {
        let mainItemId = mainItem.value
        let totalCris = document.getElementsByClassName('total-cri-point-' + mainItemId);
        let totalMain = document.querySelector('.total-main-point-' + mainItemId);
        let count = totalCris.length - 1;
        let dataTotalCrisPoint = []
        for (let i = 0; i <= count; i++) {
            dataTotalCrisPoint.push(parseFloat(totalCris[i].textContent))
            totalMain.textContent = dataTotalCrisPoint.reduce((a, b) => a + b, 0)
        }
    })
}

mentorPoint2();
memberPoint2();
adminPoint2();
sumTeamPoint();
sumMemberPoint();
sumMentorPoint();
admin();
mentor();
member();
sumAdminPoint();
sumPointUser();
getPointMember();
getPointMentor();
