<?php

namespace App\Libraries\EnumsAndConstants;

class User
{

  public const UserId = "user_id";
  public const FirstName = "first_name";
  public const LastName = "last_name";
  public const MailId = "mail_id";
  public const Password = "password";
  public const Role = "role";
  public const Status = "status";
  public const RandomKey = "random_key";
  public const Otp = "otp";
}

class Access
{

  public const AccessId = "access_id";
  public const AccessName = "access_name";
  public const PageList = "page_list";
}
class Order
{

  public const OrderListId = "order_list_id";
  public const OrderId = "order_id";
  public const ItemId = "item_id";
  public const CustomerId = "customer_id";
  public const OrderDate = "order_date";
  public const Type = "type";
  public const Colour = "colour";
  public const Length = "length";
  public const Texture = "texture";
  public const ExtSize = "ext_size";
  public const Unit = "unit";
  public const Quantity = "quantity";
  public const Status = "status";
  public const DueDate = "due_date";
  public const Overdue = "overdue";
  public const CreatedBy = "created_by";
  public const CreatedAt = "created_at";
  public const UpdatedBy = "updated_by";
  public const UpdatedAt = "updated_at";
}

class Task
{
  public const TaskId = "task_id";
  public const ParentTaskId = "parent_task_id";
  public const OrderListId = "order_list_id";
  public const EmployeeId = "employee_id";
  public const SupervisorId = "supervisor_id";
  public const StartTime = "start_time";
  public const EndTime = "end_time";
  public const TimeTaken = "time_taken";
  public const TaskName = "task_name";
  public const Sizing = "sizing";
  public const OutLength = "out_length";
  public const OutColour = "out_colour";
  public const OutTexture = "out_texture";
  public const OutQty = "out_qty";
  public const Unit = "unit";
  public const Status = "status";

  public const CreatedBy = "created_by";
  public const CreatedAt = "created_at";
  public const UpdatedBy = "updated_by";
  public const UpdatedAt = "updated_at";
}
class Stock
{
  public const StockListId = "stock_list_id";
  public const StockId = "stock_id";
  //public const OrderDate = "order_date";
  public const Colour = "colour";
  public const Length = "length";
  public const Texture = "texture";
  public const Unit = "unit";
  public const Quantity = "quantity";
  public const Status = "status";
  public const DeleteStatus = "delete_status";
  public const Type = "type";
  public const CreatedBy = "created_by";
  public const CreatedAt = "created_at";
  public const UpdatedBy = "updated_by";
  public const UpdatedAt = "updated_at";
}

class TaskDetail
{
  public const TaskDetailId = "task_detail_id";
  public const TaskName = "task_name";
  public const TimeTaken = "time_taken";
  public const Supervisor = "supervisor";
  public const DaysTaken = "days_taken";
  public const CreatedBy = "created_by";
  public const QualityAnalyst = "quality_analyst";
  public const ParentTask = "parent_task";
  public const CreatedAt = "created_at";
  public const UpdatedBy = "updated_by";
  public const UpdatedAt = "updated_at";
}

class Employee
{

  public const Id = "id";
  public const Name = "name";
  public const EmpCode = "emp_code";
  public const PhoneNo = "phone_no";
  public const DOJ = "doj";
  public const DOB = "dob";
  public const Designation = "designation";
  public const Address = "address";
  public const Status = "status";
}


class QualityCheck
{

  public const QCId = "qc_id";
  public const QCName = "qc_name";
  public const Description = "description";
}

class TaskInput
{
  public const InputId = "input_id";
  public const TaskId = "task_id";
  public const TimeTaken = "time_taken";
  public const InputCount   = "input_count	";
  public const InLength = "in_length";
  public const InColour = "in_colour";
  public const InQuantity = "in_quantity";
  public const InTexture = "in_texture";
  public const InExtSize = "in_ext_size";
  public const CreatedBy = "created_by";
  public const QualityAnalyst = "quality_analyst";
  public const ParentTask = "parent_task";
  public const CreatedAt = "created_at";
  public const UpdatedBy = "updated_by";
  public const UpdatedAt = "updated_at";
}
