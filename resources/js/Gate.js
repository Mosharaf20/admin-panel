export  default class Gate {
    constructor(user){
        this.user= user;
    }

    isAdmin(){
        return this.user.type === 'admin';
    }

    isAdminOrSUbAdmin(){
        if(this.user.type === 'admin' || this.user.type === 'sub-admin'){
            return true;
        }
    }
}
