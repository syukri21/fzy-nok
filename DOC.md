### The Class Diagram

```mermaid
classDiagram
    class User {
        - userId: int
        - username: string
        - password: string
        + authenticate(): boolean
        + changePassword(newPassword: string): void
    }

    class Admin {
        - nomorIndukKaryawan: string
        + createMasterData(): void
        + readMasterData(): void
        + updateMasterData(): void
        + deleteMasterData(): void
        + generateNewUserPassword(): string
    }

    class PPIC {
        - nomorIndukKaryawan: string
        + getProductionResults(): List~ProductionResult~
        + getOrderProducts(): List~OrderProduct~
        + orderProduct(): void
    }

    class Manager {
        - nomorIndukKaryawan: string
        + getProductionResults(): List~ProductionResult~
        + getOrderProducts(): List~OrderProduct~
        + approveProductionResult(): void
    }

    class Operator {
        - nomorIndukKaryawan: string
        + getProductionResults(): List~ProductionResult~
        + insertProductionResult(): void
        + editProductionResult(): void
    }

    class UserRole {
        - roleId: int
        - roleName: string
    }

    class MasterData {
        - masterDataId: int
        - name: string
        - type: enum~string~
        - weight: int
        - dimension: string
        - image: Image
    }

    class MasterProduct {
        - id: int
        - name: string
        - code: string
        - price: int64
        - description: string
        - requirements : List~MasterDataRequirement~
        - image: Image
    }

    class MasterDataRequirement {
        - id: int
        - masterdataId: int
        - masterproductId: int
        - masterdata: MasterData
        - masterProduct: MasterProduct
        - masterdataQty: int
    }

    class ProductionPlan {
        - id: int
        - ProductionTicket: string
        - quantity: int
        - orderDate: Date
        - dueDate: Date
        - doneDate: Date
        - ppic_nik: string
        - manager_nik: string
        - status: Enum~todo|onprogress|done~
        - operators: List~Operator~
    }

    class ProductionResult {
        - id: int
        - productionPlanId: id
        - quantityProduced: int
        - productionDate: Date
    }


    MasterDataRequirement --*  MasterProduct
    MasterData --* MasterDataRequirement

    UserRole "1" -- "0..*" User

    User <|-- PPIC
    User <|-- Admin
    User <|-- Manager
    User <|-- Operator

    PPIC "1" --* "0..*" ProductionPlan : Create, Read, Update, Delete
    Operator --* ProductionPlan
    PPIC "1" -- "0..*" ProductionResult : Read
    Manager "1" -- "0..*" ProductionPlan : Create, Read, Update, Delete
    Manager "1" -- "0..*" ProductionResult : Read, Update
    Operator "1" -- "0..*" ProductionResult : Read, Create, Update, Delete
    Admin "1" -- "0..*" MasterData: Create, Read, Update, Delete
    Admin "1" -- "0..*" MasterProduct: Create, Read, Update, Delete

    MasterProduct "1" -- "0..*" ProductionPlan
    ProductionPlan "1" -- "0..*" ProductionResult
```